@extends('operator.layout')
@section('title', 'Dashboard Operator')
@section('content')

<div class="row g-3 mb-4">

    @foreach (['Pengajuan Masuk', 'Diperiksa', 'Diproses', 'Selesai'] as $judul)
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted">{{ $judul }}</p>
                <h3 class="text-primary">—</h3>
            </div>
        </div>
    </div>
    @endforeach

</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5>Antrean Pengajuan Surat</h5>

        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jenis Surat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada pengajuan
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
