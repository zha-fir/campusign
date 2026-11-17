@extends('layouts.admin')
@section('title', 'Dashboard Super Admin')
@section('content')
<!-- JUDUL HALAMAN -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Dashboard Superadmin (A-01)</h4>
        <p class="text-muted small mb-0">Ringkasan statistik pengguna, pengajuan surat, dan kinerja SLA.</p>
    </div>

    <!-- BARIS 1: 4 KARTU STATISTIK (Total = 3 + 3 + 3 + 3 = 12 Kolom) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm">
                Petak 1: Registrasi Menunggu (A-02)
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm">
                Petak 2: Pengajuan Aktif
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm">
                Petak 3: Kinerja SLA
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm">
                Petak 4: Total Pengguna
            </div>
        </div>
    </div>

    <!-- BARIS 2: TABEL KIRI (8 KOLOM) & PANEL KANAN (4 KOLOM) (Total = 8 + 4 = 12 Kolom) -->
    <div class="row g-3">
        <!-- Kolom Kiri (Lebar 8/12) -->
        <div class="col-12 col-lg-8">
            <div class="p-4 bg-white border rounded shadow-sm">
                Petak Kiri (8 Kolom): Tempat Tabel Antrean Verifikasi Mahasiswa (A-02)
            </div>
        </div>

        <!-- Kolom Kanan (Lebar 4/12) -->
        <div class="col-12 col-lg-4">
            <div class="p-4 bg-white border rounded shadow-sm">
                Petak Kanan (4 Kolom): Tempat Ringkasan Pengajuan per Status
            </div>
        </div>
    </div>

@endsection