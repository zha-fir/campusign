<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ketua Jurusan Campusign') - Layanan Surat Jurusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
        }
    </style>
</head>

<body>
    {{-- Sidebar Ketua Jurusan --}}
    <div class="d-flex min-vh-100">
        <aside class="bg-dark text-white sidebar flex-shrink-0 p-3">
            <div class="fs-5 fw-bold mb-4 pb-2 border-bottom">
                <i class="bi bi-envelope-paper me-3"></i>CAMPUSIGN
            </div>

            <ul class="nav nav-pills flex-column gap-1">
                <!-- K-01: Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('ketua_jurusan.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('ketua_jurusan.dashboard') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <!-- K-02: Antrean Persetujuan -->
                <li class="nav-item">
                    <a href="{{ route('ketua_jurusan.antrean') }}" 
                       class="nav-link {{ request()->routeIs('ketua_jurusan.antrean*') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-inbox me-2"></i> Antrean Persetujuan
                    </a>
                </li>

                <!-- K-03: Detail dan Peninjauan -->
                <li class="nav-item">
                    <a href="{{ route('ketua_jurusan.peninjauan') }}" 
                       class="nav-link {{ request()->routeIs('ketua_jurusan.peninjauan*') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-file-earmark-text me-2"></i> Detail & Peninjauan
                    </a>
                </li>

                <!-- K-04: Riwayat Persetujuan -->
                <li class="nav-item">
                    <a href="{{ route('ketua_jurusan.riwayat') }}" 
                       class="nav-link {{ request()->routeIs('ketua_jurusan.riwayat*') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-clock-history me-2"></i> Riwayat Persetujuan
                    </a>
                </li>

                <!-- K-06: Pengaturan Tanda Tangan -->
                <li class="nav-item">
                    <a href="{{ route('ketua_jurusan.pengaturan_ttd') }}" 
                       class="nav-link {{ request()->routeIs('ketua_jurusan.pengaturan_ttd*') ? 'active text-white' : 'text-white-50' }}">
                        <i class="bi bi-pen me-2"></i> Pengaturan TTD
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow-1 d-flex flex-column bg-light">
            <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
                <div class="fw-semibold text-secondary">
                    Sistem Layanan Surat Administrasi Jurusan
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-primary">Ketua Jurusan</span>
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
    @stack('scripts')
</body>

</html>
