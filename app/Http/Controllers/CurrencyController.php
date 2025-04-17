<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code',
            'name' => 'required|string|max:50',
            'symbol' => 'required|string|max:5',
            'rate_to_idr' => 'required|numeric|min:0',
        ]);
        Currency::create($request->all());
        return redirect()->route('currencies.index')->with('success', 'Currency berhasil ditambahkan.');
    }

    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'name' => 'required|string|max:50',
            'symbol' => 'required|string|max:5',
            'rate_to_idr' => 'required|numeric|min:0',
        ]);
        $currency->update($request->all());
        return redirect()->route('currencies.index')->with('success', 'Currency berhasil diupdate.');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')->with('success', 'Currency berhasil dihapus.');
    }
}
