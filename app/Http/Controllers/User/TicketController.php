<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Ticket;
use App\Models\TicketOrder;
use App\Models\TicketOrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::query()
            ->where('is_active', true)
            ->where('name', 'Tiket Masuk')
            ->orderBy('id')
            ->limit(1)
            ->get();

        if ($tickets->isEmpty()) {
            $tickets = Ticket::query()->where('is_active', true)->orderBy('id')->limit(1)->get();
        }

        return view('user.tickets.index', compact('tickets'));
    }

    public function order(Request $request)
    {
        $data = $request->validate([
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.ticket_id' => ['required', 'exists:tickets,id'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $ticketIds = collect($data['items'])->pluck('ticket_id')->all();
        $tickets = Ticket::whereIn('id', $ticketIds)->where('is_active', true)->get()->keyBy('id');

        if ($tickets->count() !== count($ticketIds)) {
            return back()->with('error', 'Tiket tidak valid atau tidak aktif.');
        }

        $order = DB::transaction(function () use ($data, $tickets, $request) {
            $totalQty = 0;
            $totalPrice = 0;

            foreach ($data['items'] as $item) {
                $ticket = $tickets[$item['ticket_id']];
                $totalQty += (int) $item['qty'];
                $totalPrice += ((int) $item['qty'] * (float) $ticket->price);
            }

            $order = TicketOrder::create([
                'user_id' => $request->user()->id,
                'order_code' => generateUniqueCode('AT', TicketOrder::class, 'order_code'),
                'visit_date' => $data['visit_date'],
                'total_qty' => $totalQty,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            $qrDirectory = public_path('qrcodes');
            if (! is_dir($qrDirectory)) {
                mkdir($qrDirectory, 0755, true);
            }

            foreach ($data['items'] as $item) {
                $ticket = $tickets[$item['ticket_id']];
                for ($i = 0; $i < (int) $item['qty']; $i++) {
                    $ticketCode = generateUniqueCode('AT', TicketOrderItem::class, 'ticket_code');
                    $qrPath = 'qrcodes/'.$ticketCode.'.svg';
                    $qrImage = QrCode::format('svg')->size(320)->generate($ticketCode);
                    file_put_contents(public_path($qrPath), $qrImage);

                    TicketOrderItem::create([
                        'ticket_order_id' => $order->id,
                        'ticket_id' => $ticket->id,
                        'ticket_code' => $ticketCode,
                        'qr_code_path' => $qrPath,
                        'qty' => 1,
                        'price' => $ticket->price,
                    ]);
                }
            }

            return $order;
        });

        return redirect()->route('user.tickets.payment', $order->order_code)
            ->with('success', 'Pesanan tiket berhasil dibuat, silakan upload bukti bayar.');
    }

    public function payment(string $code)
    {
        $order = TicketOrder::with('items.ticket')
            ->where('order_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $banks = BankAccount::where('is_active', true)->get();

        return view('user.tickets.payment', compact('order', 'banks'));
    }

    public function uploadProof(Request $request, string $code)
    {
        $order = TicketOrder::where('order_code', $code)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $data = $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $directory = public_path('payment-proofs');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $file = $data['payment_proof'];
        $filename = now()->format('YmdHis').'_'.uniqid('proof_', true).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);
        $path = 'payment-proofs/'.$filename;

        $order->update([
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('user.tickets.download', $order->order_code)
            ->with('success', 'Bukti transfer berhasil diupload.');
    }

    public function download(string $code)
    {
        $order = TicketOrder::with('items.ticket')
            ->where('order_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('user.tickets.download', compact('order'));
    }

    public function downloadPdf(int $itemId)
    {
        $item = TicketOrderItem::with(['ticket', 'order.user'])
            ->where('id', $itemId)
            ->whereHas('order', fn ($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $order = $item->order;

        $pdf = Pdf::loadView('pdf.ticket', compact('item', 'order'));

        return $pdf->download('ticket-'.$item->ticket_code.'.pdf');
    }
}



