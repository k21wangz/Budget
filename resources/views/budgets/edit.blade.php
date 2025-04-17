@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Budget</h2>
    <form method="POST" action="{{ route('budgets.update', $budget->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="category" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $budget->category }}" required>
        </div>
        <div class="mb-3">
            <label>Rekening (opsional)</label>
            <select name="account_id" class="form-select bg-light border-0 shadow-sm rounded-pill px-3">
                <option value="">Pilih Rekening</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" @if($budget->account_id == $acc->id) selected @endif>{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Mata Uang</label>
            <select name="currency_id" class="form-select bg-light border-0 shadow-sm rounded-pill px-3" required>
                @foreach($currencies as $cur)
                    <option value="{{ $cur->id }}" @if($budget->currency_id == $cur->id) selected @endif>{{ $cur->code }} - {{ $cur->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="amount" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="0" value="{{ $budget->amount }}" required>
        </div>
        <div class="mb-3">
            <label>Periode</label>
            <select name="period" class="form-select bg-light border-0 shadow-sm rounded-pill px-3" required onchange="document.getElementById('month_field').style.display = this.value === 'monthly' ? 'block' : 'none';">
                @foreach($periods as $key => $val)
                    <option value="{{ $key }}" @if($budget->period == $key) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" id="month_field" style="display:{{ $budget->period == 'monthly' ? 'block' : 'none' }};">
            <label>Bulan</label>
            <input type="number" name="month" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="1" max="12" value="{{ $budget->month }}">
        </div>
        <div class="mb-3">
            <label>Tahun</label>
            <input type="number" name="year" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="2000" value="{{ $budget->year }}" required>
        </div>
        <div class="mb-3">
            <label>Carry Over (Sisa Bulan Lalu)</label>
            <input type="number" name="carry_over" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="0" value="{{ $budget->carry_over }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
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
