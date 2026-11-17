<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CAMPUSIGN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row min-vh-100">

        <div class="col-md-3 col-lg-2 bg-white border-end p-3">

            <h4 class="text-primary fw-bold">
                CAMPUSIGN
            </h4>

            <p class="text-muted small">Panel Operator</p>
            <hr>

            <div class="nav nav-pills flex-column gap-2">

                <a href="{{ route('operator.dashboard') }}"
                   class="nav-link {{ request()->routeIs('operator.dashboard') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>

                <a href="{{ route('operator.verifikasi') }}"
                   class="nav-link {{ request()->routeIs('operator.verifikasi') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-file-earmark-check me-2"></i>
                    Verifikasi Berkas
                </a>

                <a href="{{ route('operator.editor') }}"
                   class="nav-link {{ request()->routeIs('operator.editor') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editor Surat
                </a>

                <a href="{{ route('operator.serahTerima') }}"
                   class="nav-link {{ request()->routeIs('operator.serahTerima') ? 'active' : 'text-dark' }}">
                    <i class="bi bi-clipboard-check me-2"></i>
                    Serah Terima
                </a>
                
                <a class="nav-link text-secondary disabled"
                   aria-disabled="true">
                    <i class="bi bi-archive me-2"></i>
                    Arsip Surat Keluar
                </a>

                <a class="nav-link text-secondary disabled"
                   aria-disabled="true">
                    <i class="bi bi-bar-chart-line me-2"></i>
                    Laporan
                </a>

            </div>
        </div>

        <div class="col-md-9 col-lg-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h4>@yield('title')</h4>

                    <p class="text-muted mb-0">
                        <i class="bi bi-person-circle me-1"></i>
                        Halo, {{ auth()->user()->name }}
                    </p>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout
                    </button>
                </form>

            </div>
            @yield('content')

        </div>

    </div>
</div>

</body>
</html>
