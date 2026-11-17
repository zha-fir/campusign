@extends('layouts.kajur')
@section('title', 'Antrean Persetujuan - Ketua Jurusan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Antrean Persetujuan Surat</h4>
            <p class="text-muted mb-0 small">Daftar dokumen surat menunggu peninjauan dan tanda tangan Ketua Jurusan {{ $kajur->jurusan ?? 'Teknik Informatika' }}.</p>
        </div>
        <div>
            <!-- Aksi Persetujuan Massal (K-02) -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBulkApprove">
                <i class="bi bi-check2-all me-1"></i> Persetujuan Massal (Tanda Tangani Terpilih)
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter (K-02) -->
    <div class="card border rounded shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('ketua_jurusan.antrean') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Filter Jenis Surat</label>
                    <input type="text" name="jenis_surat" class="form-control" placeholder="Cari nama surat..." value="{{ request('jenis_surat') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status Menunggu</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Baru</option>
                        <option value="dikirim_ulang" {{ request('status') == 'dikirim_ulang' ? 'selected' : '' }}>Dikirim Ulang (Revisi Mahasiswa)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Rentang Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['jenis_surat', 'status', 'tanggal']))
                        <a href="{{ route('ketua_jurusan.antrean') }}" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Antrean dengan Checkbox Persetujuan Massal -->
    <form id="formBulk" action="{{ route('ketua_jurusan.antrean.bulk') }}" method="POST">
        @csrf
        <div class="card border rounded shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="4%" class="text-center">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </th>
                                <th>No. Tiket</th>
                                <th>Pemohon (Mahasiswa)</th>
                                <th>Jenis Surat</th>
                                <th>Tanggal Diajukan</th>
                                <th>Status Antrean</th>
                                <th class="text-center" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarAntrean as $item)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}" class="form-check-input check-item">
                                    </td>
                                    <td class="fw-semibold">#{{ $item->nomor_tiket }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->nama_mahasiswa }}</div>
                                        <small class="text-muted">NIM: {{ $item->nim }} | {{ $item->prodi }}</small>
                                    </td>
                                    <td>{{ $item->jenis_surat }}</td>
                                    <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        @if($item->status == 'dikirim_ulang')
                                            <span class="badge bg-info text-dark">
                                                <i class="bi bi-arrow-repeat me-1"></i> Dikirim Ulang
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock me-1"></i> Menunggu TTD
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('ketua_jurusan.peninjauan', $item->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye me-1"></i> Tinjau
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Tidak ada antrean dokumen surat saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($daftarAntrean->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $daftarAntrean->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

        <!-- Modal Konfirmasi Persetujuan Massal -->
        <div class="modal fade" id="modalBulkApprove" tabindex="-1" aria-labelledby="modalBulkApproveLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalBulkApproveLabel">Persetujuan Massal Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan menandatangani dan menyetujui seluruh dokumen yang Anda centang secara bersamaan.</p>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Masukkan PIN Persetujuan Tanda Tangan:</label>
                            <input type="password" name="pin" class="form-control text-center" placeholder="Masukkan 6-digit PIN" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-1"></i> Setujui & Tanda Tangani
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('checkAll')?.addEventListener('change', function() {
        document.querySelectorAll('.check-item').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endpush
@endsection
