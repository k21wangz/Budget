<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Account;
use App\Models\Currency;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with(['account', 'currency'])->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $accounts = Account::all();
        $currencies = Currency::all();
        $periods = ['monthly' => 'Bulanan', 'yearly' => 'Tahunan'];
        return view('budgets.create', compact('accounts', 'currencies', 'periods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'budget_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,yearly',
            'year' => 'required|integer|min:2000',
            'month' => 'nullable|integer|min:1|max:12',
            'carry_over' => 'nullable|numeric',
        ]);
        $data = $request->all();
        if (!isset($data['carry_over']) || $data['carry_over'] === null) {
            $data['carry_over'] = 0;
        }
        Budget::create($data);
        return redirect()->route('budgets.index')->with('success', 'Budget berhasil ditambahkan.');
    }

    public function edit(Budget $budget)
    {
        $accounts = Account::all();
        $currencies = Currency::all();
        $periods = ['monthly' => 'Bulanan', 'yearly' => 'Tahunan'];
        return view('budgets.edit', compact('budget', 'accounts', 'currencies', 'periods'));
    }

    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'budget_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:monthly,yearly',
            'year' => 'required|integer|min:2000',
            'month' => 'nullable|integer|min:1|max:12',
            'carry_over' => 'nullable|numeric',
        ]);
        $budget->update($request->all());
        return redirect()->route('budgets.index')->with('success', 'Budget berhasil diupdate.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget berhasil dihapus.');
    }
}
