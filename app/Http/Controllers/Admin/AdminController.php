<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::role('admin')->latest()->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $admin = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        $admin->assignRole('admin');

        return redirect()->route('admin.admins.index')->with('success', 'Admin baru berhasil dibuat.');
    }

    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,'.$admin->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $admin->update($payload);

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        return redirect()->route('admin.admins.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $admin->delete();

        return back()->with('success', 'Admin berhasil dihapus.');
    }
}