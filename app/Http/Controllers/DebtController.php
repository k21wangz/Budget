<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\Account;
use App\Models\Currency;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::with(['account', 'currency'])->orderBy('date', 'desc')->get();
        return view('debts.index', compact('debts'));
    }

    public function create()
    {
        $accounts = Account::all();
        $currencies = Currency::all();
        $types = ['receivable' => 'Piutang', 'payable' => 'Utang'];
        return view('debts.create', compact('accounts', 'currencies', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:receivable,payable',
            'contact_name' => 'required|string|max:255',
            'account_id' => 'required|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'date' => 'required|date',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
        Debt::create($request->all());
        return redirect()->route('debts.index')->with('success', 'Data piutang/utang berhasil ditambahkan.');
    }

    public function edit(Debt $debt)
    {
        $accounts = Account::all();
        $currencies = Currency::all();
        $types = ['receivable' => 'Piutang', 'payable' => 'Utang'];
        return view('debts.edit', compact('debt', 'accounts', 'currencies', 'types'));
    }

    public function update(Request $request, Debt $debt)
    {
        $request->validate([
            'type' => 'required|in:receivable,payable',
            'contact_name' => 'required|string|max:255',
            'account_id' => 'required|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'date' => 'required|date',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);
        $debt->update($request->all());
        return redirect()->route('debts.index')->with('success', 'Data piutang/utang berhasil diupdate.');
    }

    public function destroy(Debt $debt)
    {
        $debt->delete();
        return redirect()->route('debts.index')->with('success', 'Data piutang/utang berhasil dihapus.');
    }

    public function payForm(Debt $debt)
    {
        return view('debts.pay', compact('debt'));
    }

    public function pay(Request $request, Debt $debt)
    {
        $request->validate([
            'pay_amount' => 'required|numeric|min:1',
        ]);
        $payAmount = $request->pay_amount;
        $remaining = $debt->amount - $debt->paid;
        if ($payAmount > $remaining) {
            return back()->withErrors(['pay_amount' => 'Nominal pembayaran melebihi sisa utang/piutang.']);
        }
        // Update paid dan is_settled
        $debt->paid += $payAmount;
        if ($debt->paid >= $debt->amount) {
            $debt->is_settled = true;
        }
        $debt->save();
        // Catat transaksi ke rekening terkait
        if ($debt->type === 'payable') {
            // Pengeluaran dari rekening
            $account = $debt->account;
            if ($account->initial_balance < $payAmount) {
                return back()->withErrors(['pay_amount' => 'Saldo rekening tidak cukup untuk membayar utang.']);
            }
            $account->initial_balance -= $payAmount;
            $account->save();
            \App\Models\Transaction::create([
                'account_id' => $account->id,
                'type' => 'expense',
                'amount' => $payAmount,
                'category' => 'Pembayaran Utang',
                'description' => 'Pembayaran utang: ' . $debt->contact_name,
                'date' => now()->toDateString(),
            ]);
        } else {
            // Pemasukan ke rekening
            $account = $debt->account;
            $account->initial_balance += $payAmount;
            $account->save();
            \App\Models\Transaction::create([
                'account_id' => $account->id,
                'type' => 'income',
                'amount' => $payAmount,
                'category' => 'Pelunasan Piutang',
                'description' => 'Pelunasan piutang: ' . $debt->contact_name,
                'date' => now()->toDateString(),
            ]);
        }
        return redirect()->route('debts.index')->with('success', 'Pembayaran berhasil dicatat.');
    }
}
