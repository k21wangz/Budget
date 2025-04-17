@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Budget</h2>
    <form method="POST" action="{{ route('budgets.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Jenis Budget</label>
            <select name="type" class="form-select bg-light border-0 shadow-sm rounded-pill px-3" required>
                <option value="expense">Pengeluaran</option>
                <option value="income">Pemasukan</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input list="budget-categories" name="category" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
            <datalist id="budget-categories">
                <option value="Makan">
                <option value="Transportasi">
                <option value="Gaji">
                <option value="Belanja">
                <option value="Lainnya">
                <option value="Kesehatan">
                <option value="Pendidikan">
                <option value="Hiburan">
                <option value="Investasi">
                <option value="Tabungan">
                <option value="Zakat">
                <option value="Cicilan">
                <option value="Donasi">
                <option value="Pajak">
                <option value="Asuransi">
            </datalist>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Budget</label>
            <input type="text" name="budget_name" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
        </div>
        <div class="mb-3">
            <label>Rekening (opsional)</label>
            <select name="account_id" class="form-control">
                <option value="">Pilih Rekening</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Mata Uang</label>
            <select name="currency_id" class="form-control" required>
                <option value="">Pilih Mata Uang</option>
                @foreach($currencies as $cur)
                    <option value="{{ $cur->id }}">{{ $cur->code }} - {{ $cur->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="amount" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
            <label>Periode</label>
            <select name="period" class="form-control" required onchange="document.getElementById('month_field').style.display = this.value === 'monthly' ? 'block' : 'none';">
                @foreach($periods as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" id="month_field">
            <label>Bulan</label>
            <input type="number" name="month" class="form-control" min="1" max="12">
        </div>
        <div class="mb-3">
            <label>Tahun</label>
            <input type="number" name="year" class="form-control" min="2000" value="{{ date('Y') }}" required>
        </div>
        <div class="mb-3">
            <label>Carry Over (Sisa Bulan Lalu)</label>
            <input type="number" name="carry_over" class="form-control" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('budgets.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var period = document.querySelector('select[name=period]');
        var monthField = document.getElementById('month_field');
        monthField.style.display = period.value === 'monthly' ? 'block' : 'none';
    });
</script>
@endsection
