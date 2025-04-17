@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Budget</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('budgets.create') }}" class="btn btn-primary mb-3">Tambah Budget</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Nama Budget</th>
                <th>Kategori</th>
                <th>Rekening</th>
                <th>Mata Uang</th>
                <th>Nominal</th>
                <th>Periode</th>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Carry Over</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($budgets as $b)
            <tr>
                <td>{{ ucfirst($b->type) }}</td>
                <td>{{ $b->category }}</td>
                <td>{{ $b->budget_name }}</td>
                <td>{{ $b->category }}</td>
                <td>{{ $b->account->name ?? '-' }}</td>
                <td>{{ $b->currency->code ?? '-' }}</td>
                <td>{{ number_format($b->amount,2,',','.') }}</td>
                <td>{{ ucfirst($b->period) }}</td>
                <td>{{ $b->year }}</td>
                <td>{{ $b->month ?? '-' }}</td>
                <td>{{ number_format($b->carry_over,2,',','.') }}</td>
                <td>
                    <a href="{{ route('budgets.edit', $b->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('budgets.destroy', $b->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus budget ini?')">
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
