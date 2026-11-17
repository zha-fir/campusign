@extends('layouts.kajur')
@section('title', 'Dashboard Ketua Jurusan')

@section('content')
    <!-- JUDUL HALAMAN -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Dashboard Ketua Jurusan (K-01)</h4>
            <p class="text-muted small mb-0">Ringkasan pengajuan surat dan status penandatanganan dokumen di Jurusan {{ $kajur->jurusan ?? 'Teknik Informatika' }}.</p>
        </div>
        <div>
            <a href="{{ route('ketua_jurusan.antrean') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-inbox me-1"></i> Buka Antrean Persetujuan
            </a>
        </div>
    </div>

    <!-- BARIS 1: 4 KARTU STATISTIK (3 + 3 + 3 + 3 = 12 Kolom) -->
    <div class="row g-3 mb-4">
        <!-- Petak 1: Dokumen Menunggu -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm h-100 d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Dokumen Menunggu</div>
                    <h3 class="fw-bold my-1 text-primary">{{ $statistik['dokumen_menunggu'] ?? 0 }}</h3>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Perlu Tinjauan</span>
                </div>
                <div class="p-3 rounded-circle bg-primary-subtle text-primary">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>

        <!-- Petak 2: Rata-rata Waktu Proses -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm h-100 d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Rata-rata Waktu Proses</div>
                    <h3 class="fw-bold my-1 text-dark">{{ $statistik['rata_waktu_proses'] ?? '1.5 Hari' }}</h3>
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Kecepatan Layanan</span>
                </div>
                <div class="p-3 rounded-circle bg-light text-secondary border">
                    <i class="bi bi-stopwatch fs-4"></i>
                </div>
            </div>
        </div>

        <!-- Petak 3: Surat Disetujui -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm h-100 d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Surat Disetujui</div>
                    <h3 class="fw-bold my-1 text-success">{{ $statistik['dokumen_disetujui'] ?? 0 }}</h3>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Bulan Ini</span>
                </div>
                <div class="p-3 rounded-circle bg-success-subtle text-success">
                    <i class="bi bi-check2-circle fs-4"></i>
                </div>
            </div>
        </div>

        <!-- Petak 4: Diminta Revisi -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 bg-white border rounded shadow-sm h-100 d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold">Diminta Revisi</div>
                    <h3 class="fw-bold my-1 text-danger">{{ $statistik['dokumen_revisi'] ?? 0 }}</h3>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Dikembalikan</span>
                </div>
                <div class="p-3 rounded-circle bg-danger-subtle text-danger">
                    <i class="bi bi-arrow-repeat fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- BARIS 2: TABEL KIRI (8 KOLOM) & PANEL KANAN (4 KOLOM) -->
    <div class="row g-3">
        <!-- Kolom Kiri (8 Kolom): Antrean Surat Perlu Ditinjau -->
        <div class="col-12 col-lg-8">
            <div class="bg-white border rounded shadow-sm">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-list-task me-1"></i> Antrean Surat Perlu Ditinjau Segera
                    </h6>
                    <a href="{{ route('ketua_jurusan.antrean') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
                <div class="p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Surat</th>
                                    <th>Pemohon</th>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal Masuk</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($antreanTerbaru as $item)
                                    <tr>
                                        <td class="fw-semibold">#{{ $item->nomor_tiket }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->nama_mahasiswa }}</div>
                                            <small class="text-muted">NIM: {{ $item->nim }}</small>
                                        </td>
                                        <td>{{ $item->jenis_surat }}</td>
                                        <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('ketua_jurusan.peninjauan', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye me-1"></i> Tinjau
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                            Tidak ada dokumen menunggu persetujuan saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (4 Kolom): Ringkasan Status & Info Akses Jurusan -->
        <div class="col-12 col-lg-4">
            <div class="bg-white border rounded shadow-sm p-4 h-100">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-shield-check text-primary me-1"></i> Hak Akses Dokumen Jurusan
                </h6>
                <p class="text-muted small mb-4">
                    Sistem otomatis menyaring dokumen. Anda hanya berhak memverifikasi dan menandatangani permohonan surat dari mahasiswa di Jurusan <strong>{{ $kajur->jurusan ?? 'Teknik Informatika' }}</strong>.
                </p>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted">Pejabat Kajur</span>
                        <span class="fw-semibold small">{{ $kajur->nama_lengkap ?? auth()->user()->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted">Spesimen Tanda Tangan</span>
                        @if($kajur->tanda_tangan)
                            <span class="badge bg-success-subtle text-success">Terpasang</span>
                        @else
                            <a href="{{ route('ketua_jurusan.pengaturan_ttd') }}" class="small text-warning text-decoration-none">
                                Unggah <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Keamanan PIN Otorisasi</span>
                        @if($kajur->pin_persetujuan)
                            <span class="badge bg-primary">Aktif</span>
                        @else
                            <a href="{{ route('ketua_jurusan.pengaturan_ttd') }}" class="small text-danger text-decoration-none">
                                Belum Dibuat <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
