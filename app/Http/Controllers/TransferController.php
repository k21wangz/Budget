<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function create()
    {
        $accounts = Account::all();
        $adminFees = [0, 2500, 5000, 6500, 10000]; // Contoh pilihan biaya admin
        return view('transfer.create', compact('accounts', 'adminFees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_account_id' => 'required|different:to_account_id|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1',
            'admin_fee' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $transfer = Transfer::create([
                'from_account_id' => $request->from_account_id,
                'to_account_id' => $request->to_account_id,
                'amount' => $request->amount,
                'admin_fee' => $request->admin_fee,
                'date' => $request->date,
                'description' => $request->description,
            ]);

            // Update saldo rekening sumber (kurangi amount + admin_fee)
            $from = Account::find($request->from_account_id);
            $from->initial_balance -= ($request->amount + $request->admin_fee);
            $from->save();

            // Update saldo rekening tujuan (tambah amount)
            $to = Account::find($request->to_account_id);
            $to->initial_balance += $request->amount;
            $to->save();

            // Catat transaksi keluar di rekening sumber
            \App\Models\Transaction::create([
                'account_id' => $from->id,
                'type' => 'expense',
                'amount' => $request->amount,
                'category' => 'Transfer Keluar',
                'description' => 'Transfer ke rekening ID ' . $to->id,
                'date' => $request->date,
            ]);

            // Catat transaksi masuk di rekening tujuan
            \App\Models\Transaction::create([
                'account_id' => $to->id,
                'type' => 'income',
                'amount' => $request->amount,
                'category' => 'Transfer Masuk',
                'description' => 'Transfer dari rekening ID ' . $from->id,
                'date' => $request->date,
            ]);

            // Catat biaya admin sebagai transaksi pengeluaran pada rekening sumber
            if ($request->admin_fee > 0) {
                \App\Models\Transaction::create([
                    'account_id' => $from->id,
                    'type' => 'admin_fee',
                    'amount' => $request->admin_fee,
                    'category' => 'Biaya Admin Transfer',
                    'description' => 'Biaya admin transfer ke rekening ID ' . $to->id,
                    'date' => $request->date,
                ]);
            }
        });

        return redirect()->route('transfer.create')->with('success', 'Transfer berhasil disimpan.');
    }
}
