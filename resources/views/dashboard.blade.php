@php
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\Debt;

$totalBalance = Account::sum('initial_balance');
$totalIncome = Transaction::where('type', 'income')->sum('amount');
$totalExpense = Transaction::where('type', 'expense')->sum('amount');
$totalAdminFee = Transaction::where('type', 'admin_fee')->sum('amount');
// Pisahkan total budget pemasukan dan pengeluaran
$totalBudgetIncome = Budget::where('type', 'income')->sum('amount');
$totalBudgetExpense = Budget::where('type', 'expense')->sum('amount');
$totalReceivable = Debt::where('type', 'receivable')->where('is_settled', false)->sum('amount');
$totalPayable = Debt::where('type', 'payable')->where('is_settled', false)->sum('amount');

$month = date('n');
$year = date('Y');
$budgetCategories = Budget::where('period', 'monthly')->where('month', $month)->where('year', $year)->get();

// Notifikasi budget hampir habis
$notifBudgets = [];
foreach($budgetCategories as $budget) {
    $used = \App\Models\Transaction::where('category', $budget->category)
        ->where('type', 'expense')
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->sum('amount');
    $percent = $budget->amount > 0 ? ($used / $budget->amount) * 100 : 0;
    if($percent >= 80) {
        $notifBudgets[] = [
            'category' => $budget->category,
            'percent' => round($percent),
            'used' => $used,
            'amount' => $budget->amount
        ];
    }
}
// Notifikasi utang/piutang jatuh tempo
$notifDebts = \App\Models\Debt::where('is_settled', false)
    ->whereNotNull('due_date')
    ->whereDate('due_date', '<=', now()->addDays(3)->toDateString())
    ->get();

$minAccounts = \App\Models\Account::whereColumn('initial_balance', '<', 'min_balance')->get();

$monthlyIncome = [];
$monthlyExpense = [];
for($m=1;$m<=12;$m++){
    $monthlyIncome[] = Transaction::where('type','income')->whereYear('date',$year)->whereMonth('date',$m)->sum('amount');
    $monthlyExpense[] = Transaction::where('type','expense')->whereYear('date',$year)->whereMonth('date',$m)->sum('amount');
}
@endphp

@extends('layouts.app')
@section('content')
@if(count($notifBudgets) > 0 || $notifDebts->count() > 0)
<div class="alert alert-warning">
    <h5>Notifikasi</h5>
    <ul class="mb-0">
        @foreach($notifBudgets as $nb)
            <li>Budget kategori <b>{{ $nb['category'] }}</b> sudah terpakai {{ $nb['percent'] }}% (Rp {{ number_format($nb['used'],0,',','.') }} dari Rp {{ number_format($nb['amount'],0,',','.') }})</li>
        @endforeach
        @foreach($notifDebts as $debt)
            <li>{{ $debt->type == 'payable' ? 'Utang' : 'Piutang' }} <b>{{ $debt->contact_name }}</b> jatuh tempo pada {{ $debt->due_date }} (Sisa: Rp {{ number_format($debt->amount - $debt->paid,0,',','.') }})</li>
        @endforeach
    </ul>
</div>
@endif
@if($minAccounts->count() > 0)
<div class="alert alert-danger">
    <b>Peringatan!</b> Saldo rekening berikut di bawah batas minimum:<br>
    <ul>
        @foreach($minAccounts as $acc)
            <li>{{ $acc->name }} (Saldo: Rp {{ number_format($acc->initial_balance,0,',','.') }}, Minimum: Rp {{ number_format($acc->min_balance,0,',','.') }})</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-primary h-100">
            <div class="card-body">
                <h6 class="card-title">Total Saldo</h6>
                <h3 class="card-text">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success h-100">
            <div class="card-body">
                <h6 class="card-title">Total Pemasukan</h6>
                <h4 class="card-text">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-danger h-100">
            <div class="card-body">
                <h6 class="card-title">Total Pengeluaran</h6>
                <h4 class="card-text">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning h-100">
            <div class="card-body">
                <h6 class="card-title">Total Biaya Admin</h6>
                <h5 class="card-text">Rp {{ number_format($totalAdminFee, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-info h-100">
            <div class="card-body">
                <h6 class="card-title">Total Budget Pemasukan</h6>
                <h5 class="card-text">Rp {{ number_format($totalBudgetIncome, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-info h-100">
            <div class="card-body">
                <h6 class="card-title">Total Budget Pengeluaran</h6>
                <h5 class="card-text">Rp {{ number_format($totalBudgetExpense, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-secondary h-100">
            <div class="card-body">
                <h6 class="card-title">Piutang Belum Lunas</h6>
                <h5 class="card-text">Rp {{ number_format($totalReceivable, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-dark h-100">
            <div class="card-body">
                <h6 class="card-title">Sisa Utang</h6>
                <h5 class="card-text">Rp {{ number_format(\App\Models\Debt::where('type', 'payable')->where('is_settled', false)->sum(\DB::raw('amount - paid')), 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-primary h-100">
            <div class="card-body">
                <h6 class="card-title">Sisa Budget (Estimasi)</h6>
                <h5 class="card-text">Rp {{ number_format($totalBudgetExpense - $totalExpense, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
</div>
<div class="row g-3 mb-4">
    @foreach($budgetCategories as $budget)
        @php
            if($budget->type == 'income') {
                $used = Transaction::where('category', $budget->category)
                    ->where('type', 'income')
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->sum('amount');
                $percent = $budget->amount > 0 ? min(100, round(($used / $budget->amount) * 100)) : 0;
            } else {
                $used = Transaction::where('category', $budget->category)
                    ->where('type', 'expense')
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->sum('amount');
                $percent = $budget->amount > 0 ? min(100, round(($used / $budget->amount) * 100)) : 0;
            }
        @endphp
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Budget {{ $budget->category }} Bulan Ini</h6>
                    <div class="progress mb-2" style="height: 25px;">
                        <div class="progress-bar {{ $percent >= 100 ? 'bg-danger' : ($percent >= 80 ? 'bg-warning' : 'bg-success') }}" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $percent }}%
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        @if($budget->type == 'income')
                            <span>Terpenuhi: Rp {{ number_format($used,0,',','.') }}</span>
                            <span>Sisa: Rp {{ number_format($budget->amount - $used,0,',','.') }}</span>
                        @else
                            <span>Terpakai: Rp {{ number_format($used,0,',','.') }}</span>
                            <span>Sisa: Rp {{ number_format($budget->amount - $used,0,',','.') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@php
$incomeBudgets = Budget::where('period', 'yearly')->where('year', $year)->get();
@endphp
<div class="row g-3 mb-4">
    @foreach($incomeBudgets as $budget)
        @php
            $income = Transaction::where('category', $budget->category)
                ->where('type', 'income')
                ->whereYear('date', $year)
                ->sum('amount');
            $color = $income > $budget->amount ? 'bg-success' : ($income == $budget->amount ? 'bg-primary' : 'bg-danger');
            $percent = $budget->amount > 0 ? min(100, round(($income / $budget->amount) * 100)) : 0;
        @endphp
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title">Target Pemasukan {{ $budget->category }} Tahun Ini</h6>
                    <div class="progress mb-2" style="height: 25px;">
                        <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $percent }}%
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tercapai: Rp {{ number_format($income,0,',','.') }}</span>
                        <span>Target: Rp {{ number_format($budget->amount,0,',','.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Grafik Tren Pemasukan & Pengeluaran {{ $year }}</h5>
                <canvas id="trendChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('trendChart').getContext('2d');
    const trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($monthlyIncome),
                    borderColor: 'green',
                    backgroundColor: 'rgba(0,128,0,0.1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Pengeluaran',
                    data: @json($monthlyExpense),
                    borderColor: 'red',
                    backgroundColor: 'rgba(255,0,0,0.1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
<!-- <div class="row">
    <div class="col-md-12">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-download"></i> Backup Data</h5>
                        <a href="{{ route('backup.all') }}" class="btn btn-success rounded-pill px-4"><i class="bi bi-file-earmark-excel"></i> Download Backup (Excel)</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-white">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-upload"></i> Restore Data</h5>
                        <form method="POST" action="{{ route('restore.data') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2">
                                <input type="file" name="file" accept=".xlsx" class="form-control bg-light border-0 shadow-sm rounded-pill px-3" required>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="bi bi-arrow-repeat"></i> Upload & Restore</button>
                        </form>
                        @if(session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
