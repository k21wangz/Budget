<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\CurrencyController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/transfer/create', [App\Http\Controllers\TransferController::class, 'create'])->name('transfer.create');
Route::post('/transfer', [App\Http\Controllers\TransferController::class, 'store'])->name('transfer.store');

Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
Route::get('/accounts/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
Route::put('/accounts/{account}', [AccountController::class, 'update'])->name('accounts.update');
Route::delete('/accounts/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy');

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');
Route::get('/backup', [TransactionController::class, 'backupAll'])->name('backup.all');
Route::post('/restore', [TransactionController::class, 'restore'])->name('restore.data');

Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
Route::get('/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
Route::get('/budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
Route::put('/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');
Route::get('/budgets/export/excel', [TransactionController::class, 'exportBudgetExcel'])->name('budgets.export.excel');

Route::get('/debts', [DebtController::class, 'index'])->name('debts.index');
Route::get('/debts/create', [DebtController::class, 'create'])->name('debts.create');
Route::post('/debts', [DebtController::class, 'store'])->name('debts.store');
Route::get('/debts/{debt}/edit', [DebtController::class, 'edit'])->name('debts.edit');
Route::put('/debts/{debt}', [DebtController::class, 'update'])->name('debts.update');
Route::delete('/debts/{debt}', [DebtController::class, 'destroy'])->name('debts.destroy');
Route::get('/debts/{debt}/pay', [DebtController::class, 'payForm'])->name('debts.payForm');
Route::post('/debts/{debt}/pay', [DebtController::class, 'pay'])->name('debts.pay');

Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
Route::get('/currencies/create', [CurrencyController::class, 'create'])->name('currencies.create');
Route::post('/currencies', [CurrencyController::class, 'store'])->name('currencies.store');
Route::get('/currencies/{currency}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
Route::put('/currencies/{currency}', [CurrencyController::class, 'update'])->name('currencies.update');
Route::delete('/currencies/{currency}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');
