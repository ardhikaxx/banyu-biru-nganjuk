<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Booking;
use App\Models\Place;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private function resolvePendopo(): Place
    {
        $pendopo = Place::whereRaw('LOWER(name) = ?', ['pendopo'])
            ->where('is_active', true)
            ->first();

        if (! $pendopo) {
            $pendopo = Place::where('is_active', true)->orderBy('id')->firstOrFail();
        }

        return $pendopo;
    }

    public function index()
    {
        $place = $this->resolvePendopo();

        return view('user.bookings.index', compact('place'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'visitor_name' => ['required', 'string', 'max:100'],
            'visitor_phone' => ['required', 'string', 'max:20'],
            'visitor_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $place = $this->resolvePendopo();

        $exists = Booking::where('place_id', $place->id)
            ->whereDate('booking_date', $data['booking_date'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Tanggal sudah dibooking, silakan pilih tanggal lain.');
        }

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'place_id' => $place->id,
            'booking_code' => generateUniqueCode('AB', Booking::class, 'booking_code'),
            'booking_date' => $data['booking_date'],
            'visitor_name' => $data['visitor_name'],
            'visitor_phone' => $data['visitor_phone'],
            'visitor_address' => $data['visitor_address'],
            'num_persons' => 1,
            'total_price' => $place->price_per_day,
            'notes' => $data['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('user.bookings.payment', $booking->booking_code)
            ->with('success', 'Booking berhasil dibuat. Silakan upload bukti transfer.');
    }

    public function payment(string $code)
    {
        $booking = Booking::with('place')
            ->where('booking_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $banks = BankAccount::where('is_active', true)->get();

        return view('user.bookings.payment', compact('booking', 'banks'));
    }

    public function uploadProof(Request $request, string $code)
    {
        $booking = Booking::where('booking_code', $code)
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

        $booking->update([
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('user.bookings.status', $booking->booking_code)
            ->with('success', 'Bukti transfer booking berhasil diupload.');
    }

    public function status(string $code)
    {
        $booking = Booking::with('place')
            ->where('booking_code', $code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('user.bookings.status', compact('booking'));
    }

    public function checkDate(Request $request)
    {
        $data = $request->validate([
            'booking_date' => ['required', 'date'],
        ]);

        $place = $this->resolvePendopo();

        $isBooked = Booking::where('place_id', $place->id)
            ->whereDate('booking_date', $data['booking_date'])
            ->exists();

        return response()->json([
            'available' => ! $isBooked,
            'message' => $isBooked
                ? 'Tanggal ini sudah dibooking. Silakan pilih tanggal lain.'
                : 'Tanggal tersedia.',
        ]);
    }
}