<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copilot Budget</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: 100vh; }
        .navbar-brand { font-weight: bold; }
        .nav-link.active { font-weight: bold; color: #6366f1 !important; }
        .card { box-shadow: 0 2px 8px rgba(99,102,241,0.04); border-radius: 1rem; background: #fff; }
        .card-title { color: #212529; font-weight: 600; } /* Ubah warna judul card jadi hitam */
        .card-text, .card-body, .progress-bar, .progress, .form-label, .form-control, .form-select, .btn, .alert, .navbar, .nav-link, .table, .table th, .table td, body, h1, h2, h3, h4, h5, h6, p, label, span, div {
            color: #212529 !important;
        }
        .btn-primary, .bg-primary, .progress-bar.bg-primary { background-color: #6366f1 !important; border-color: #6366f1 !important; }
        .btn-success, .bg-success, .progress-bar.bg-success { background-color: #22c55e !important; border-color: #22c55e !important; }
        .btn-danger, .bg-danger, .progress-bar.bg-danger { background-color: #ef4444 !important; border-color: #ef4444 !important; }
        .btn-warning, .bg-warning, .progress-bar.bg-warning { background-color: #f59e42 !important; border-color: #f59e42 !important; }
        .btn-info, .bg-info, .progress-bar.bg-info { background-color: #0ea5e9 !important; border-color: #0ea5e9 !important; }
        .text-bg-primary { background: #6366f1 !important; color: #fff !important; }
        .text-bg-success { background: #22c55e !important; color: #fff !important; }
        .text-bg-danger { background: #ef4444 !important; color: #fff !important; }
        .text-bg-warning { background: #f59e42 !important; color: #fff !important; }
        .text-bg-info { background: #0ea5e9 !important; color: #fff !important; }
        .text-bg-secondary { background: #64748b !important; color: #fff !important; }
        .text-bg-dark { background: #334155 !important; color: #fff !important; }
        .border-primary { border-color: #6366f1 !important; }
        .navbar { border-bottom: 2px solid #f1f5f9; background: #fff !important; }
        .navbar-brand i { color: #6366f1; }
        .footer-icon { color: #6366f1; }
        @media (max-width: 767px) {
            .container { padding-left: 0.5rem; padding-right: 0.5rem; }
            .navbar .container { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <i class="bi bi-wallet2"></i> Copilot Budget
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('accounts*') ? 'active' : '' }}" href="/accounts">Rekening</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}" href="/transactions">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('budgets*') ? 'active' : '' }}" href="/budgets">Budget</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('debts*') ? 'active' : '' }}" href="/debts">Piutang/Utang</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('currencies*') ? 'active' : '' }}" href="/currencies">Currency</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('transfer*') ? 'active' : '' }}" href="/transfer/create">Transfer</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container pb-4">
    @yield('content')
</div>
<footer class="text-center text-muted py-3 small mt-4">
    &copy; {{ date('Y') }} Copilot Budget &middot; <i class="bi bi-phone footer-icon"></i> Mobile Friendly
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
