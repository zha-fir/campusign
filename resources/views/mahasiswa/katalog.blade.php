@extends('layouts.mahasiswa')

@section('title', 'Katalog surat')

@section('content')

<h1 class="h3 fw-bold mb-4">Katalog surat</h1>

<div class="row g-4">
    @forelse ($jenisSurat as $id => $j)
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h2 class="h6 fw-bold mb-3">{{ $j['nama'] }}</h2>

                    <div class="small fw-semibold mb-1">Persyaratan</div>
                    @if (count($j['syarat']) > 0)
                        <ul class="small text-muted ps-3 mb-3">
                            @foreach ($j['syarat'] as $s)
                                <li>{{ $s['nama'] }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="small text-muted mb-3">Belum diatur</div>
                    @endif

                    <div class="small fw-semibold mb-1">Lama pengerjaan (SLA)</div>
                    <div class="small text-muted mb-3">
                        {{ $j['sla'] ? $j['sla'] . ' hari kerja' : '-' }}
                    </div>

                    <div class="small fw-semibold mb-1">Estimasi tanggal selesai</div>
                    <div class="small text-muted mb-3 flex-grow-1">{{ $j['estimasi'] ?? '-' }}</div>

                    <a href="#" onclick="return false;" class="btn btn-primary">Ajukan</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-muted">Belum ada jenis surat aktif.</div>
            </div>
        </div>
    @endforelse
</div>

@endsection