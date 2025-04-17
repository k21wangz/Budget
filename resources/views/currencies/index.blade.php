@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Mata Uang</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('currencies.create') }}" class="btn btn-primary mb-3">Tambah Mata Uang</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Simbol</th>
                <th>Kurs ke IDR</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currencies as $cur)
            <tr>
                <td>{{ $cur->code }}</td>
                <td>{{ $cur->name }}</td>
                <td>{{ $cur->symbol }}</td>
                <td>{{ number_format($cur->rate_to_idr,2,',','.') }}</td>
                <td>
                    <a href="{{ route('currencies.edit', $cur->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('currencies.destroy', $cur->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus currency ini?')">
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
