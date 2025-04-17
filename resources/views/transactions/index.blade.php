@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Transaksi</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Rekening</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $trx->date }}</td>
                <td>{{ $trx->account->name ?? '-' }}</td>
                <td>{{ ucfirst($trx->type) }}</td>
                <td>{{ $trx->category }}</td>
                <td>{{ number_format($trx->amount,2,',','.') }}</td>
                <td>{{ $trx->description }}</td>
                <td>
                    <a href="{{ route('transactions.edit', $trx->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
