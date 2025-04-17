<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Budget;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Exports\BudgetsExport;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('account')->orderBy('date', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $accounts = Account::all();
        // Ambil semua kategori budget untuk pengeluaran
        $expenseCategories = Budget::where('type', 'expense')->pluck('category')->unique();
        // Ambil semua kategori budget untuk pemasukan
        $incomeCategories = Budget::where('type', 'income')->pluck('category')->unique();
        return view('transactions.create', compact('accounts', 'expenseCategories', 'incomeCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense,admin_fee',
            'amount' => 'required|numeric|min:1',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $account = Account::findOrFail($request->account_id);
        $amount = $request->amount;
        $type = $request->type;

        // Validasi saldo cukup untuk pengeluaran
        if ($type === 'expense' || $type === 'admin_fee') {
            if ($account->initial_balance < $amount) {
                return redirect()->back()->withInput()->withErrors(['amount' => 'Saldo rekening tidak cukup untuk pengeluaran ini.']);
            }
            $account->initial_balance -= $amount;
        } else if ($type === 'income') {
            $account->initial_balance += $amount;
        }
        $account->save();

        Transaction::create($request->except('_token'));
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        $accounts = Account::all();
        $categories = ['Makanan', 'Transportasi', 'Gaji', 'Belanja', 'Lainnya'];
        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:income,expense,admin_fee',
            'amount' => 'required|numeric|min:1',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);
        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }

    public function exportBudgetExcel()
    {
        return Excel::download(new BudgetsExport, 'budgets.xlsx');
    }

    public function backupAll()
    {
        $date = now()->format('Ymd_His');
        $transactions = new \App\Exports\TransactionsExport();
        $budgets = new \App\Exports\BudgetsExport();
        $txFile = "backup_transactions_{$date}.xlsx";
        $budgetFile = "backup_budgets_{$date}.xlsx";
        Excel::store($transactions, $txFile, 'local');
        Excel::store($budgets, $budgetFile, 'local');
        return response()->download(storage_path("app/{$txFile}"))->deleteFileAfterSend(true);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);
        // Implementasi restore manual sesuai kebutuhan (bisa pakai Laravel Excel import)
        return back()->with('success', 'Restore data berhasil (dummy, implementasi import sesuai kebutuhan).');
    }
}
