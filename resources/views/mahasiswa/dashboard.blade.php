@extends('layouts.mahasiswa')

@section('title', 'Beranda')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold mb-0">Halo, {{ auth()->user()->name }}</h1>
    <a href="#" onclick="return false;" class="btn btn-primary">Ajukan surat</a>
</div>

@forelse ($pengumuman as $info)
    <div class="alert alert-warning" role="alert">
        <strong>{{ $info['judul'] }} ({{ $info['tanggal'] }}).</strong> {{ $info['isi'] }}
    </div>
@empty
    <div class="alert alert-light border" role="alert">
        <strong>Pengumuman.</strong> Belum ada pengumuman libur atau penutupan.
    </div>
@endforelse

@forelse ($siapDiambil as $s)
    <div class="alert alert-success" role="alert">
        <strong>{{ $s['jenis'] }}</strong> ({{ $s['no'] }}) siap diambil di {{ $s['pickup']['tempat'] }}.
        Batas pengambilan {{ $s['pickup']['batas'] }}
        @if ($s['sisa'] >= 0) ({{ $s['sisa'] }} hari lagi). @else (sudah lewat). @endif
    </div>
@empty
    <div class="alert alert-light border" role="alert">
        <strong>Surat siap diambil.</strong> Belum ada surat yang siap diambil.
    </div>
@endforelse

<h2 class="h5 fw-semibold mb-3 mt-4">Pengajuan aktif per status</h2>
<div class="row g-3 mb-4">
    @foreach ($ringkasan as $kode => $jumlah)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100"
                 style="border-left-color: var(--bs-{{ $statusLabels[$kode]['warna'] }});">
                <div class="card-body">
                    <div class="angka">{{ $jumlah }}</div>
                    <div class="text-muted small mt-1">{{ $statusLabels[$kode]['label'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Pengajuan terbaru</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>Nomor</th><th>Jenis surat</th><th>Tanggal</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($terbaru as $s)
                            <tr>
                                <td class="fw-semibold">{{ $s['no'] }}</td>
                                <td>{{ $s['jenis'] }}</td>
                                <td>{{ $s['tanggal'] }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $statusLabels[$s['status']]['warna'] }}">
                                        {{ $statusLabels[$s['status']]['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Notifikasi terbaru</div>
            <ul class="list-group list-group-flush">
                @forelse ($notifikasi as $n)
                    <li class="list-group-item {{ $n['dibaca'] ? '' : 'belum-dibaca' }}">
                        <div class="small">{{ $n['pesan'] }}</div>
                        <div class="text-muted" style="font-size:.75rem;">{{ $n['waktu'] }}</div>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Belum ada notifikasi.</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>

@endsection