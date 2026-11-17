@extends('layouts.kajur')
@section('title', 'Pengaturan Tanda Tangan - Ketua Jurusan')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Pengaturan Keamanan & Tanda Tangan</h4>
        <p class="text-muted mb-0 small">Kelola spesimen tanda tangan digital, PIN otorisasi, dan metode validasi persetujuan surat.</p>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alert Validasi Error -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- 1. Spesimen Tanda Tangan Digital -->
        <div class="col-md-6">
            <div class="card border rounded shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-pen me-2 text-primary"></i> 1. Spesimen Gambar Tanda Tangan
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Unggah gambar spesimen tanda tangan Anda dalam format transparan (.PNG) untuk dibubuhkan pada surat digital.</p>
                    
                    <div class="border border-dashed p-4 text-center rounded bg-light mb-3">
                        @if(isset($kajur) && $kajur->tanda_tangan)
                            <div class="py-2">
                                <img src="{{ asset('storage/' . $kajur->tanda_tangan) }}" alt="Tanda Tangan Kajur" style="max-height: 120px;" class="img-fluid">
                                <span class="d-block text-success small mt-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Spesimen aktif terpasang
                                </span>
                            </div>
                        @else
                            <div class="text-muted py-3">
                                <i class="bi bi-card-image fs-1 text-secondary d-block mb-2"></i>
                                <span>Belum ada file tanda tangan diunggah</span>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('ketua_jurusan.pengaturan_ttd.spesimen') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Pilih File Tanda Tangan (.PNG background transparan):</label>
                            <input type="file" name="spesimen" class="form-control" accept="image/png" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-upload me-1"></i> Simpan Spesimen
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. Pengaturan PIN Keamanan Otorisasi -->
        <div class="col-md-6">
            <div class="card border rounded shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-shield-lock me-2 text-primary"></i> 2. PIN Persetujuan Tanda Tangan
                    </h6>
                    @if(isset($kajur) && $kajur->pin_persetujuan)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            <i class="bi bi-shield-check me-1"></i> PIN Aktif
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum Dibuat
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <p class="text-muted small">PIN 6-digit angka wajib dimasukkan setiap kali Anda menyetujui atau menandatangani dokumen surat demi keamanan otorisasi.</p>
                    
                    <form action="{{ route('ketua_jurusan.pengaturan_ttd.pin') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">PIN Baru (6 Digit Angka):</label>
                            <input type="password" name="pin_baru" class="form-control" placeholder="Contoh: 123456" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Konfirmasi PIN Baru:</label>
                            <input type="password" name="konfirmasi_pin" class="form-control" placeholder="Ulangi 6 angka PIN" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-key me-1"></i> Simpan / Perbarui PIN
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 3. Metode Sertifikat Digital / QR Validasi -->
        <div class="col-12">
            <div class="card border rounded shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-qr-code me-2 text-primary"></i> 3. Metode Validasi Dokumen (QR Code & Sertifikat)
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Setiap surat yang diterbitkan secara otomatis dilengkapi dengan kode QR dan tautan verifikasi keaslian dokumen.</p>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="switchQr" checked>
                        <label class="form-check-label fw-semibold" for="switchQr">Sematkan QR Code Verifikasi pada Footer Surat</label>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="switchNotify" checked>
                        <label class="form-check-label fw-semibold" for="switchNotify">Kirim Notifikasi Email saat ada dokumen baru masuk antrean</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
