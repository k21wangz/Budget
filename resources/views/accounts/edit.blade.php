@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Rekening</h2>
    <form method="POST" action="{{ route('accounts.update', $account->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Rekening</label>
            <input type="text" name="name" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $account->name }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mata Uang</label>
            <select name="currency_id" class="form-select bg-light border-0 shadow-sm rounded-pill px-3" required>
                @foreach($currencies as $cur)
                    <option value="{{ $cur->id }}" @if($account->currency_id == $cur->id) selected @endif>{{ $cur->code }} - {{ $cur->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Saldo Awal</label>
            <input type="number" name="initial_balance" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $account->initial_balance }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Saldo Minimum</label>
            <input type="number" name="min_balance" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="0" value="{{ old('min_balance', $account->min_balance ?? 0) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe Rekening</label>
            <select name="type" class="form-select bg-light border-0 shadow-sm rounded-pill px-3" required>
                <option value="bank" @if($account->type=='bank') selected @endif>Bank</option>
                <option value="ewallet" @if($account->type=='ewallet') selected @endif>E-Wallet</option>
                <option value="cash" @if($account->type=='cash') selected @endif>Cash</option>
                <option value="other" @if($account->type=='other') selected @endif>Lainnya</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="description" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ $account->description }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
