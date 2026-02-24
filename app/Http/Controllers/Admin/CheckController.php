<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TicketOrderItem;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function ticketIndex()
    {
        return view('admin.check.ticket');
    }

    public function checkTicket(Request $request)
    {
        $data = $request->validate([
            'ticket_code' => ['required', 'string', 'max:20'],
            'mark_used' => ['nullable', 'boolean'],
        ]);

        $item = TicketOrderItem::with(['ticket', 'order.user'])
            ->where('ticket_code', strtoupper(trim($data['ticket_code'])))
            ->first();

        if (! $item) {
            return back()->with('error', 'Kode tiket tidak ditemukan.');
        }

        if ($request->boolean('mark_used') && ! $item->is_used) {
            $item->update([
                'is_used' => true,
                'used_at' => now(),
            ]);
        }

        return back()->with('ticketItem', $item)->with('success', 'Pengecekan tiket berhasil.');
    }

    public function bookingIndex()
    {
        return view('admin.check.booking');
    }

    public function checkBooking(Request $request)
    {
        $data = $request->validate([
            'booking_code' => ['required', 'string', 'max:20'],
            'action' => ['nullable', 'in:confirm,reject'],
            'rejection_note' => ['nullable', 'string'],
        ]);

        $booking = Booking::with(['user', 'place'])
            ->where('booking_code', strtoupper(trim($data['booking_code'])))
            ->first();

        if (! $booking) {
            return back()->with('error', 'Kode booking tidak ditemukan.');
        }

        if (($data['action'] ?? null) === 'confirm') {
            $booking->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => auth()->id(),
                'rejection_note' => null,
            ]);
        }

        if (($data['action'] ?? null) === 'reject') {
            $booking->update([
                'status' => 'rejected',
                'confirmed_by' => auth()->id(),
                'rejection_note' => $data['rejection_note'] ?? 'Ditolak oleh admin.',
            ]);
        }

        return back()->with('booking', $booking->fresh(['user', 'place']))->with('success', 'Pengecekan booking berhasil.');
    }
}