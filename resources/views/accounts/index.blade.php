@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Rekening</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('accounts.create') }}" class="btn btn-primary mb-3">Tambah Rekening</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Rekening</th>
                <th>Mata Uang</th>
                <th>Saldo Awal</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $acc)
            <tr>
                <td>{{ $acc->name }}</td>
                <td>{{ $acc->currency->code ?? '-' }}</td>
                <td>{{ number_format($acc->initial_balance,2,',','.') }}</td>
                <td>{{ ucfirst($acc->type) }}</td>
                <td>{{ $acc->description }}</td>
                <td>
                    <a href="{{ route('accounts.edit', $acc->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('accounts.destroy', $acc->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus rekening ini?')">
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
