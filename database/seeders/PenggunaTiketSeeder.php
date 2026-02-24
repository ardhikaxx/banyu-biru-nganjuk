<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketOrder;
use App\Models\TicketOrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PenggunaTiketSeeder extends Seeder
{
    public function run(): void
    {
        $ticket = Ticket::where('name', 'Tiket Masuk')->first();
        $admin = User::where('email', 'admin@banyubiru.com')->first();
        $users = User::role('user')->orderBy('id')->get();

        if (! $ticket || $users->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'confirmed', 'rejected'];

        for ($i = 1; $i <= 18; $i++) {
            $visitDate = Carbon::now()->subMonths($i % 12)->addDays(($i * 2) % 20 + 1)->toDateString();
            $qty = ($i % 4) + 1;
            $status = $statuses[$i % 3];
            $orderCode = 'AT-DEMO-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT);

            $order = TicketOrder::updateOrCreate(
                ['order_code' => $orderCode],
                [
                    'user_id' => $users[$i % $users->count()]->id,
                    'visit_date' => $visitDate,
                    'total_qty' => $qty,
                    'total_price' => $qty * (float) $ticket->price,
                    'status' => $status,
                    'confirmed_at' => $status === 'confirmed' ? now()->subDays($i) : null,
                    'confirmed_by' => $status === 'confirmed' && $admin ? $admin->id : null,
                    'rejection_note' => $status === 'rejected' ? 'Data pembayaran tidak valid.' : null,
                ]
            );

            TicketOrderItem::where('ticket_order_id', $order->id)->delete();

            for ($j = 1; $j <= $qty; $j++) {
                $ticketCode = 'AT-ITM-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT).str_pad((string) $j, 2, '0', STR_PAD_LEFT);

                TicketOrderItem::create([
                    'ticket_order_id' => $order->id,
                    'ticket_id' => $ticket->id,
                    'ticket_code' => $ticketCode,
                    'qr_code_path' => 'qrcodes/'.$ticketCode.'.svg',
                    'qty' => 1,
                    'price' => $ticket->price,
                    'is_used' => false,
                ]);
            }
        }
    }
}
