@extends('operator.layout')
@section('title', 'Verifikasi Berkas')
@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5>Daftar Pengajuan Mahasiswa</h5>
        <p class="text-muted">
            Pemeriksaan berkas pengajuan surat.
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Jenis Surat</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada berkas
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
