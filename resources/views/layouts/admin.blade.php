<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Campusign') - Layanan Surat Jurusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 230px;
        }
    </style>
</head>

<body>
    {{-- ini sidebar --}}
    <div class="d-flex min-vh-100">
        <aside class="bg-dark text-white sidebar flex-shrink-0 p-3">
            <div class="fs-5 fw-bold mb-4 pb-2 border-bottom">
                <i class="bi bi-envelope-paper me-3"></i>CAMPUSIGN
            </div>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white-50">
                        <i class="bi bi-person-check me-2"></i> Verifikasi Akun
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white-50">
                        <i class="bi bi-file-earmark-text me-2"></i> Jenis Surat
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.daftarpengajuan') }}"
                        class="nav-link {{ request()->routeIs('admin.daftarpengajuan') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-folder2-open me-2"></i> Semua Pengajuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.datamhs') }}"
                        class="nav-link {{ request()->routeIs('admin.datamhs*') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-person-lines-fill me-2"></i> Data Mahasiswa
                    </a>
                </li>
            </ul>
        </aside>

        <div class="flex-grow-1 d-flex flex-column bg-light">
            <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
                <div class="fw-semibold text-secondary">
                    Sistem Layanan Surat Administrasi Jurusan
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-primary">Superadmin</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>
            <main class="container-fluid p-4">
                @yield('content')
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>