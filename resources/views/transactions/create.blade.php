@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Transaksi</h2>
    <div class="mb-3">
        <button class="btn btn-outline-success me-2" id="btn-income" type="button">Input Pemasukan</button>
        <button class="btn btn-outline-danger" id="btn-expense" type="button">Input Pengeluaran</button>
    </div>
    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf
        <input type="hidden" name="type" id="type-input" value="expense">
        <div class="mb-3">
            <label>Rekening</label>
            <select name="account_id" class="form-control" required>
                <option value="">Pilih Rekening</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category" class="form-select bg-light border-0 shadow-sm" id="category-select" required>
                <option value="">Pilih Kategori</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="amount" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="1" required>
            @if($errors->has('amount'))
                <div class="alert alert-danger">{{ $errors->first('amount') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="description" class="form-control bg-light border-0 shadow-sm rounded-pill px-3">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script>
    const expenseCategories = @json($expenseCategories);
    const incomeCategories = @json($incomeCategories);
    function updateCategoryOptions(type) {
        const select = document.getElementById('category-select');
        select.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Pilih Kategori';
        select.appendChild(placeholder);
        let cats = [];
        if(type === 'income') cats = incomeCategories;
        else if(type === 'expense') cats = expenseCategories;
        cats.forEach(cat => {
            const opt = document.createElement('option');
            opt.value = cat;
            opt.textContent = cat;
            select.appendChild(opt);
        });
    }
    document.getElementById('btn-income').addEventListener('click', function() {
        document.getElementById('type-input').value = 'income';
        updateCategoryOptions('income');
        this.classList.add('active');
        document.getElementById('btn-expense').classList.remove('active');
    });
    document.getElementById('btn-expense').addEventListener('click', function() {
        document.getElementById('type-input').value = 'expense';
        updateCategoryOptions('expense');
        this.classList.add('active');
        document.getElementById('btn-income').classList.remove('active');
    });
    document.addEventListener('DOMContentLoaded', function() {
        updateCategoryOptions('expense');
        document.getElementById('btn-expense').classList.add('active');
    });
</script>
@endsection
