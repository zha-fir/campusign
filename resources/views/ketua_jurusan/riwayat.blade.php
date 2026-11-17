@extends('layouts.kajur')
@section('title', 'Riwayat Persetujuan - Ketua Jurusan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Keputusan & Persetujuan</h4>
            <p class="text-muted mb-0 small">Daftar arsip seluruh dokumen yang telah disetujui & ditandatangani di Jurusan {{ $kajur->jurusan ?? 'Teknik Informatika' }}.</p>
        </div>
        <div>
            <!-- Form Pencarian Cepat -->
            <form action="{{ route('ketua_jurusan.riwayat') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari No. Tiket, Nama, NIM..." value="{{ request('q') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('q'))
                    <a href="{{ route('ketua_jurusan.riwayat') }}" class="btn btn-sm btn-outline-secondary" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Riwayat Persetujuan (K-04) -->
    <div class="card border rounded shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>No. Tiket</th>
                            <th>Pemohon (Mahasiswa)</th>
                            <th>Jenis Surat</th>
                            <th>Keputusan</th>
                            <th>Waktu Tanda Tangan</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarRiwayat as $index => $item)
                            <tr>
                                <td class="text-center">{{ $daftarRiwayat->firstItem() + $index }}</td>
                                <td class="fw-semibold">#{{ $item->nomor_tiket }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $item->nama_mahasiswa }}</div>
                                    <small class="text-muted">NIM: {{ $item->nim }} | {{ $item->prodi }}</small>
                                </td>
                                <td>{{ $item->jenis_surat }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-check-circle me-1"></i> Disetujui
                                    </span>
                                </td>
                                <td>
                                    {{ $item->tanggal_disetujui ? $item->tanggal_disetujui->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Tombol Lihat Dokumen -->
                                        <a href="{{ route('ketua_jurusan.peninjauan', $item->id) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Pratinjau">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Tombol Unduh PDF Resmi (K-04) -->
                                        <a href="{{ route('ketua_jurusan.unduh_pdf', $item->id) }}" class="btn btn-sm btn-primary" title="Unduh File PDF">
                                            <i class="bi bi-download me-1"></i> Unduh PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-check fs-2 d-block mb-2"></i>
                                    Belum ada arsip dokumen yang disetujui.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($daftarRiwayat->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $daftarRiwayat->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
