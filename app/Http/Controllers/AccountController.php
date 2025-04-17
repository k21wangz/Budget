<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Currency;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('currency')->get();
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        $currencies = Currency::all();
        return view('accounts.create', compact('currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'currency_id' => 'required|exists:currencies,id',
            'initial_balance' => 'required|numeric',
            'type' => 'required|in:bank,ewallet,cash,other',
            'description' => 'nullable|string',
        ]);
        Account::create($request->all());
        return redirect()->route('accounts.index')->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function edit(Account $account)
    {
        $currencies = Currency::all();
        return view('accounts.edit', compact('account', 'currencies'));
    }

    public function update(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'currency_id' => 'required|exists:currencies,id',
            'initial_balance' => 'required|numeric',
            'type' => 'required|in:bank,ewallet,cash,other',
            'description' => 'nullable|string',
        ]);
        $account->update($request->all());
        return redirect()->route('accounts.index')->with('success', 'Rekening berhasil diupdate.');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Rekening berhasil dihapus.');
    }
}
