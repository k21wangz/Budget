@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Pembayaran {{ $debt->type == 'payable' ? 'Utang' : 'Piutang' }}</h2>
    <div class="mb-3">
        <strong>Nama Pihak:</strong> {{ $debt->contact_name }}<br>
        <strong>Nominal Utang/Piutang:</strong> Rp {{ number_format($debt->amount,0,',','.') }}<br>
        <strong>Sudah Dibayar:</strong> Rp {{ number_format($debt->paid,0,',','.') }}<br>
        <strong>Sisa:</strong> Rp {{ number_format($debt->amount - $debt->paid,0,',','.') }}<br>
    </div>
    <form method="POST" action="{{ route('debts.pay', $debt->id) }}">
        @csrf
        <div class="mb-3">
            <label>Nominal Pembayaran</label>
            <input type="number" name="pay_amount" class="form-control" min="1" max="{{ $debt->amount - $debt->paid }}" required>
            @if($errors->has('pay_amount'))
                <div class="alert alert-danger">{{ $errors->first('pay_amount') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-success">Bayar</button>
        <a href="{{ route('debts.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
