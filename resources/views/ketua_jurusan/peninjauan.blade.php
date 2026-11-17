@extends('layouts.kajur')
@section('title', 'Detail & Peninjauan Dokumen')

@section('content')
<div class="container-fluid">
    @if(!$surat)
        <div class="alert alert-warning border-0 shadow-sm p-4 text-center">
            <i class="bi bi-info-circle fs-1 text-warning d-block mb-2"></i>
            <h5>Tidak ada dokumen surat yang perlu ditinjau</h5>
            <p class="text-muted">Semua permohonan surat di jurusan Anda telah diproses atau belum ada pengajuan baru.</p>
            <a href="{{ route('ketua_jurusan.antrean') }}" class="btn btn-primary btn-sm">Kembali ke Antrean</a>
        </div>
    @else
        <!-- Tombol Kembali & Judul -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('ketua_jurusan.antrean') }}" class="btn btn-sm btn-outline-secondary mb-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Antrean
                </a>
                <h4 class="fw-bold mb-0">Peninjauan & Persetujuan Dokumen #{{ $surat->nomor_tiket }}</h4>
            </div>
            <div class="d-flex gap-2">
                @if($surat->status != 'disetujui')
                    <!-- Aksi: Minta Revisi (Modal Catatan Wajib) -->
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalRevisi">
                        <i class="bi bi-arrow-repeat me-1"></i> Minta Revisi
                    </button>

                    <!-- Aksi: Setujui dan Tanda Tangan -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSetujui">
                        <i class="bi bi-pen-fill me-1"></i> Setujui & Tanda Tangan
                    </button>
                @else
                    <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 border border-success-subtle align-self-center">
                        <i class="bi bi-check-circle-fill me-1"></i> Sudah Disetujui
                    </span>
                    <a href="{{ route('ketua_jurusan.unduh_pdf', $surat->id) }}" class="btn btn-primary">
                        <i class="bi bi-download me-1"></i> Unduh PDF Resmi
                    </a>
                @endif
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
            <!-- Kolom Kiri: Pratinjau Dokumen Surat (PDF Viewer / Draft Surat) -->
            <div class="col-lg-8">
                <div class="card border rounded shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-file-earmark-pdf text-danger me-1"></i> Pratinjau Dokumen Surat
                        </h6>
                        <span class="badge {{ $surat->status == 'disetujui' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $surat->status == 'disetujui' ? 'Dokumen Sah Diterbitkan' : 'Draft Siap Ditandatangani' }}
                        </span>
                    </div>
                    <div class="card-body p-4 bg-light text-center">
                        <!-- Lembar Dokumen Simulasi -->
                        <div class="bg-white p-5 shadow-sm rounded mx-auto text-start" style="max-width: 650px; min-height: 700px;">
                            <div class="text-center border-bottom pb-3 mb-4">
                                <h6 class="fw-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h6>
                                <h6 class="fw-bold mb-1">FAKULTAS TEKNIK - JURUSAN {{ strtoupper($surat->jurusan ?? 'TEKNIK INFORMATIKA') }}</h6>
                                <small class="text-muted">Jl. Kampus Terpadu No. 1, Kota Pendidikan | Email: jurusanti@campus.ac.id</small>
                            </div>

                            <div class="text-center my-4">
                                <h6 class="fw-bold text-decoration-underline mb-1">{{ strtoupper($surat->jenis_surat) }}</h6>
                                <small class="text-muted">Nomor: {{ $surat->nomor_surat ?? '142/UN.FT/TI/' . date('Y') }}</small>
                            </div>

                            <p>Yang bertanda tangan di bawah ini Ketua Jurusan {{ $surat->jurusan ?? 'Teknik Informatika' }} menerangkan bahwa:</p>
                            
                            <table class="table table-borderless my-3">
                                <tr><td width="32%" class="py-1">Nama Mahasiswa</td><td width="3%">:</td><td class="fw-semibold py-1">{{ $surat->nama_mahasiswa }}</td></tr>
                                <tr><td class="py-1">NIM</td><td>:</td><td class="fw-semibold py-1">{{ $surat->nim }}</td></tr>
                                <tr><td class="py-1">Program Studi</td><td>:</td><td class="py-1">{{ $surat->prodi }}</td></tr>
                                <tr><td class="py-1">Semester / Angkatan</td><td>:</td><td class="py-1">Semester {{ $surat->semester }} / {{ $surat->angkatan }}</td></tr>
                            </table>

                            <p class="mt-4">
                                Adalah benar mahasiswa aktif pada Program Studi {{ $surat->prodi }} Jurusan {{ $surat->jurusan }} pada Tahun Akademik {{ date('Y') }}/{{ date('Y')+1 }}.
                                Surat keterangan ini diberikan untuk keperluan: <strong>{{ $surat->keperluan }}</strong>.
                            </p>

                            <div class="mt-5 text-end">
                                <p class="mb-1">Ketua Jurusan,</p>
                                <div class="py-2" style="min-height: 80px;">
                                    @if(isset($kajur) && $kajur->tanda_tangan)
                                        <img src="{{ asset('storage/' . $kajur->tanda_tangan) }}" alt="Tanda Tangan Kajur" style="max-height: 75px;">
                                    @else
                                        <div class="border border-dashed p-2 d-inline-block text-muted small">
                                            [ Area Tanda Tangan Digital Resmi ]
                                        </div>
                                    @endif
                                </div>
                                <p class="fw-bold text-decoration-underline mt-2 mb-0">{{ $kajur->nama_lengkap ?? auth()->user()->name }}</p>
                                <small class="text-muted">NIP. {{ $kajur->nip ?? '197805122003121002' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan Pemohon & Riwayat Revisi -->
            <div class="col-lg-4">
                <!-- Ringkasan Pemohon (K-03) -->
                <div class="card border rounded shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-person-lines-fill me-1 text-primary"></i> Ringkasan Pemohon
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="bi bi-person fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ $surat->nama_mahasiswa }}</h6>
                                <span class="text-muted small">NIM: {{ $surat->nim }}</span>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Jurusan</span>
                                <span class="fw-semibold">{{ $surat->jurusan }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Program Studi</span>
                                <span class="fw-semibold">{{ $surat->prodi }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Angkatan</span>
                                <span class="fw-semibold">{{ $surat->angkatan }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Nomor WhatsApp</span>
                                <span class="fw-semibold">{{ $surat->no_hp ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Status Dokumen</span>
                                <span class="badge {{ $surat->status == 'disetujui' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($surat->status) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Riwayat Revisi (K-03) -->
                <div class="card border rounded shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-clock-history me-1 text-secondary"></i> Riwayat Pengajuan & Timeline
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline small">
                            <div class="border-start border-2 border-primary ps-3 pb-3 position-relative">
                                <span class="position-absolute top-0 start-0 translate-middle p-1 bg-primary border border-light rounded-circle"></span>
                                <div class="fw-bold">Pengajuan Dikirim</div>
                                <div class="text-muted">{{ $surat->created_at->format('d M Y, H:i') }}</div>
                                <div class="mt-1">Mahasiswa mengajukan permohonan {{ $surat->jenis_surat }}.</div>
                            </div>
                            @if($surat->catatan_revisi)
                                <div class="border-start border-2 border-danger ps-3 pb-3 position-relative">
                                    <span class="position-absolute top-0 start-0 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                    <div class="fw-bold text-danger">Catatan Revisi Terakhir</div>
                                    <div class="mt-1 text-danger fst-italic">"{{ $surat->catatan_revisi }}"</div>
                                </div>
                            @endif
                            <div class="ps-3 position-relative">
                                <span class="position-absolute top-0 start-0 translate-middle p-1 {{ $surat->status == 'disetujui' ? 'bg-success' : 'bg-secondary' }} border border-light rounded-circle"></span>
                                <div class="fw-bold {{ $surat->status == 'disetujui' ? 'text-success' : 'text-secondary' }}">
                                    {{ $surat->status == 'disetujui' ? 'Disetujui Kajur' : 'Menunggu TTD Kajur' }}
                                </div>
                                <div class="text-muted">
                                    {{ $surat->tanggal_disetujui ? $surat->tanggal_disetujui->format('d M Y, H:i') : 'Saat ini' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Setujui & Tanda Tangan (K-03) -->
        <div class="modal fade" id="modalSetujui" tabindex="-1" aria-labelledby="modalSetujuiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalSetujuiLabel">
                            <i class="bi bi-check2-circle me-1"></i> Konfirmasi Tanda Tangan Dokumen
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('ketua_jurusan.peninjauan.setujui', $surat->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin menyetujui dan membubuhkan tanda tangan digital pada surat ini?</p>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Masukkan PIN Tanda Tangan Kajur:</label>
                                <input type="password" name="pin" class="form-control form-control-lg text-center" placeholder="6 Digit PIN" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required autofocus>
                                <small class="text-muted">Masukkan 6 digit PIN otorisasi Anda.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-pen me-1"></i> Ya, Tanda Tangani & Terbitkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Minta Revisi (K-03 - Catatan Wajib) -->
        <div class="modal fade" id="modalRevisi" tabindex="-1" aria-labelledby="modalRevisiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold" id="modalRevisiLabel">
                            <i class="bi bi-exclamation-triangle me-1"></i> Minta Revisi Pengajuan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('ketua_jurusan.peninjauan.revisi', $surat->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p class="text-muted small">Surat akan dikembalikan ke pemohon dengan instruksi perbaikan berikut:</p>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Catatan Revisi <span class="text-danger">* (Wajib diisi)</span>:</label>
                                <textarea name="catatan_revisi" class="form-control" rows="4" placeholder="Tuliskan poin yang perlu diperbaiki oleh mahasiswa..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-send me-1"></i> Kirim Catatan Revisi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
