@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Piutang/Utang</h2>
    <form method="POST" action="{{ route('debts.store') }}">
        @csrf
        <div class="mb-3">
            <label>Jenis</label>
            <select name="type" class="form-control" required>
                @foreach($types as $key => $val)
                    <option value="{{ $key }}">{{ $val }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nama Pihak</label>
            <input type="text" name="contact_name" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
        </div>
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
            <input type="number" name="amount" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="0" required>
        </div>
        <div class="mb-3">
            <label>Sudah Dibayar (opsional)</label>
            <input type="number" name="paid" class="form-control" min="0">
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label>Jatuh Tempo (opsional)</label>
            <input type="date" name="due_date" class="form-control bg-light border-0 shadow-sm rounded-pill px-3">
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('debts.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
