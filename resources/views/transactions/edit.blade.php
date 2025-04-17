@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Transaksi</h2>
    <div class="mb-3">
        <button class="btn btn-outline-success me-2" id="btn-income" type="button">Edit Pemasukan</button>
        <button class="btn btn-outline-danger" id="btn-expense" type="button">Edit Pengeluaran</button>
    </div>
    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="type" id="type-input" value="{{ $transaction->type }}">
        <div class="mb-3">
            <label>Rekening</label>
            <select name="account_id" class="form-control" required>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" @if($transaction->account_id == $acc->id) selected @endif>{{ $acc->name }}</option>
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
            <input type="number" name="amount" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="1" value="{{ $transaction->amount }}" required>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $transaction->date }}" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="description" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $transaction->description }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script>
    const expenseCategories = @json($expenseCategories);
    const incomeCategories = @json($incomeCategories);
    function updateCategoryOptions(type, selected) {
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
            if(selected === cat) opt.selected = true;
            select.appendChild(opt);
        });
    }
    document.getElementById('btn-income').addEventListener('click', function() {
        document.getElementById('type-input').value = 'income';
        updateCategoryOptions('income', '{{ $transaction->category }}');
        this.classList.add('active');
        document.getElementById('btn-expense').classList.remove('active');
    });
    document.getElementById('btn-expense').addEventListener('click', function() {
        document.getElementById('type-input').value = 'expense';
        updateCategoryOptions('expense', '{{ $transaction->category }}');
        this.classList.add('active');
        document.getElementById('btn-income').classList.remove('active');
    });
    document.addEventListener('DOMContentLoaded', function() {
        const type = '{{ $transaction->type }}';
        updateCategoryOptions(type, '{{ $transaction->category }}');
        if(type === 'income') document.getElementById('btn-income').classList.add('active');
        else document.getElementById('btn-expense').classList.add('active');
    });
</script>
@endsection
