<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('admin.tickets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'quota_per_day' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Ticket::create([
            ...$data,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.tickets.index')->with('success', 'Data tiket berhasil ditambah.');
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'quota_per_day' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $ticket->update([
            ...$data,
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.tickets.index')->with('success', 'Data tiket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return back()->with('success', 'Data tiket berhasil dihapus.');
    }
}