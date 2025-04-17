@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Piutang/Utang</h2>
    <form method="POST" action="{{ route('debts.update', $debt->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Jenis</label>
            <select name="type" class="form-control" required>
                @foreach($types as $key => $val)
                    <option value="{{ $key }}" @if($debt->type == $key) selected @endif>{{ $val }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nama Pihak</label>
            <input type="text" name="contact_name" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $debt->contact_name }}" required>
        </div>
        <div class="mb-3">
            <label>Rekening</label>
            <select name="account_id" class="form-control" required>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" @if($debt->account_id == $acc->id) selected @endif>{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Mata Uang</label>
            <select name="currency_id" class="form-control" required>
                @foreach($currencies as $cur)
                    <option value="{{ $cur->id }}" @if($debt->currency_id == $cur->id) selected @endif>{{ $cur->code }} - {{ $cur->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="amount" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="0" value="{{ $debt->amount }}" required>
        </div>
        <div class="mb-3">
            <label>Sudah Dibayar (opsional)</label>
            <input type="number" name="paid" class="form-control" min="0" value="{{ $debt->paid }}">
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ $debt->date }}" required>
        </div>
        <div class="mb-3">
            <label>Jatuh Tempo (opsional)</label>
            <input type="date" name="due_date" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $debt->due_date }}">
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="description" class="form-control" value="{{ $debt->description }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('debts.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
