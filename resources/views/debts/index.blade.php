@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Daftar Piutang/Utang</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('debts.create') }}" class="btn btn-primary mb-3">Tambah Piutang/Utang</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Nama Pihak</th>
                <th>Rekening</th>
                <th>Mata Uang</th>
                <th>Nominal</th>
                <th>Sudah Dibayar</th>
                <th>Tanggal</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($debts as $d)
            <tr>
                <td>{{ $d->type == 'receivable' ? 'Piutang' : 'Utang' }}</td>
                <td>{{ $d->contact_name }}</td>
                <td>{{ $d->account->name ?? '-' }}</td>
                <td>{{ $d->currency->code ?? '-' }}</td>
                <td>{{ number_format($d->amount,2,',','.') }}</td>
                <td>{{ number_format($d->paid,2,',','.') }}</td>
                <td>{{ $d->date }}</td>
                <td>{{ $d->due_date ?? '-' }}</td>
                <td>{{ $d->is_settled ? 'Lunas' : 'Belum Lunas' }}</td>
                <td>{{ $d->description }}</td>
                <td>
                    <a href="{{ route('debts.edit', $d->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('debts.destroy', $d->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    @if(!$d->is_settled)
                        <a href="{{ route('debts.payForm', $d->id) }}" class="btn btn-sm btn-success">Bayar</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
