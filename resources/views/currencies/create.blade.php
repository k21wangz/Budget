@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Mata Uang</h2>
    <form method="POST" action="{{ route('currencies.store') }}">
        @csrf
        <div class="mb-3">
            <label>Kode</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
        </div>
        <div class="mb-3">
            <label>Simbol</label>
            <input type="text" name="symbol" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
        </div>
        <div class="mb-3">
            <label>Kurs ke IDR</label>
            <input type="number" name="rate_to_idr" class="form-control" min="0" step="0.0001" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
