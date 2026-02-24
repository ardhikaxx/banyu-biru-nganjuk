<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::latest()->get();

        return view('admin.bank-accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('admin.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        BankAccount::create([
            ...$data,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil ditambah.');
    }

    public function edit(BankAccount $bank_account)
    {
        return view('admin.bank-accounts.edit', ['bankAccount' => $bank_account]);
    }

    public function update(Request $request, BankAccount $bank_account)
    {
        $data = $request->validate([
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $bank_account->update([
            ...$data,
            'is_active' => $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.bank-accounts.index')->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy(BankAccount $bank_account)
    {
        $bank_account->delete();

        return back()->with('success', 'Rekening bank berhasil dihapus.');
    }
}