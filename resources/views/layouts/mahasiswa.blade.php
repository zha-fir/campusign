<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - CAMPUSIGN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --sidebar-w: 260px; }
        body { background: #f5f7fa; }

        .stat-card { border-left: 4px solid var(--bs-primary); }
        .stat-card .angka { font-size: 1.75rem; font-weight: 700; line-height: 1; }
        .belum-dibaca { background: #eef4ff; border-left: 3px solid #0d6efd; }

        .sidebar { width: var(--sidebar-w); background: #fff; }
        .sidebar .brand { letter-spacing: .06em; font-weight: 700; font-size: 1.75rem; color: #0d6efd; }
        .sidebar .offcanvas-header { display: flex !important; padding: 1.25rem 1rem; }
        .sidebar .nav-link { color: #495057; border-radius: .5rem; padding: .6rem .9rem; display: flex; align-items: center; gap: .6rem; }
        .sidebar .nav-link:hover { background: #eef4ff; color: #0d6efd; }
        .sidebar .nav-link.active { background: #0d6efd; color: #fff; }

        @media (min-width: 992px) {
            .sidebar { position: fixed; top: 0; left: 0; bottom: 0; border-right: 1px solid #e3e6ec; }
            .main-wrap { margin-left: var(--sidebar-w); }
        }
    </style>
</head>
<body>

<nav class="navbar bg-white border-bottom d-lg-none sticky-top">
    <div class="container-fluid">
        <button class="btn btn-outline-primary" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-label="Buka menu">
            <i class="bi bi-list fs-5"></i>
        </button>
        <span class="navbar-brand mb-0 fw-bold text-primary">CAMPUSIGN</span>
        <span style="width:42px"></span>
    </div>
</nav>

<div class="offcanvas-lg offcanvas-start sidebar d-flex flex-column" tabindex="-1" id="sidebarMenu">

    <div class="offcanvas-header border-bottom">
        <div>
            <div class="brand">CAMPUSIGN</div>
            <small class="text-muted">Layanan surat jurusan</small>
        </div>
        <button type="button" class="btn-close d-lg-none"
                data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Tutup"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3">

        <ul class="nav nav-pills flex-column gap-1">

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"
                   href="{{ route('mahasiswa.dashboard') }}"><i class="bi bi-house-door"></i> Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.katalog') ? 'active' : '' }}"
                   href="{{ route('mahasiswa.katalog') }}"><i class="bi bi-journal-text"></i> Katalog surat</a>
            </li>

        
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="return false;">
                    <i class="bi bi-pencil-square"></i> Form pengajuan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="return false;">
                    <i class="bi bi-diagram-3"></i> Status dan linimasa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="return false;">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="return false;">
                    <i class="bi bi-bell"></i> Notifikasi
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('mahasiswa.profil') ? 'active' : '' }}"
                   href="{{ route('mahasiswa.profil') }}"><i class="bi bi-person-circle"></i> Profil akun</a>
            </li>
        </ul>

        <div class="mt-auto pt-3 border-top">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-person-circle fs-3 text-secondary"></i>
                <div class="lh-sm">
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <small class="text-muted">Mahasiswa</small>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

    </div>
</div>

<main class="main-wrap">
    <div class="container-fluid p-3 p-lg-4">


        @if (session('sukses'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sukses') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @yield('content')

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>