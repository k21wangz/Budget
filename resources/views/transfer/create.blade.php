@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Transfer Antar Rekening</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('transfer.store') }}">
        @csrf
        <div class="mb-3">
            <label>Dari Rekening</label>
            <select name="from_account_id" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
                <option value="">Pilih rekening sumber</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Ke Rekening</label>
            <select name="to_account_id" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
                <option value="">Pilih rekening tujuan</option>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nominal Transfer</label>
            <input type="number" name="amount" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" min="1" required>
        </div>
        <div class="mb-3">
            <label>Biaya Admin</label>
            <select name="admin_fee" class="form-control" onchange="if(this.value=='manual'){document.getElementById('admin_fee_manual').style.display='block';}else{document.getElementById('admin_fee_manual').style.display='none';}">
                @foreach($adminFees as $fee)
                    <option value="{{ $fee }}">{{ number_format($fee,0,',','.') }}</option>
                @endforeach
                <option value="manual">Input Manual</option>
            </select>
            <input type="number" name="admin_fee_manual" id="admin_fee_manual" class="form-control mt-2" style="display:none;" placeholder="Masukkan biaya admin manual">
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="description" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Transfer</button>
    </form>
</div>
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        var select = document.querySelector('select[name=admin_fee]');
        if(select.value === 'manual') {
            var manual = document.getElementById('admin_fee_manual').value;
            if(!manual || isNaN(manual) || manual < 0) {
                alert('Masukkan nominal biaya admin yang valid!');
                e.preventDefault();
            } else {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'admin_fee';
                input.value = manual;
                this.appendChild(input);
            }
        }
    });
</script>
@endsection
