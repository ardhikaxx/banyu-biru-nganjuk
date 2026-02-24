<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketOrder;
use Illuminate\Http\Request;

class TicketOrderController extends Controller
{
    public function index()
    {
        $orders = TicketOrder::with('user')->latest()->get();

        return view('admin.ticket-orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = TicketOrder::with(['user', 'items.ticket'])->findOrFail($id);

        return view('admin.ticket-orders.show', compact('order'));
    }

    public function confirm(int $id)
    {
        $order = TicketOrder::findOrFail($id);

        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => auth()->id(),
            'rejection_note' => null,
        ]);

        return back()->with('success', 'Order tiket berhasil dikonfirmasi.');
    }

    public function reject(Request $request, int $id)
    {
        $data = $request->validate([
            'rejection_note' => ['required', 'string'],
        ]);

        $order = TicketOrder::findOrFail($id);

        $order->update([
            'status' => 'rejected',
            'confirmed_by' => auth()->id(),
            'rejection_note' => $data['rejection_note'],
        ]);

        return back()->with('success', 'Order tiket ditolak.');
    }
}