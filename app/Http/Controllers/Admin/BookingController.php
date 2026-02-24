<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'place'])->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(int $id)
    {
        $booking = Booking::with(['user', 'place'])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(int $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
            'rejection_note' => null,
        ]);

        return back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function reject(Request $request, int $id)
    {
        $data = $request->validate([
            'rejection_note' => ['required', 'string'],
        ]);

        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'rejected',
            'confirmed_by' => auth()->id(),
            'rejection_note' => $data['rejection_note'],
        ]);

        return back()->with('success', 'Booking ditolak.');
    }
}