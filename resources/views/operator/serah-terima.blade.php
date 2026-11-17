@extends('operator.layout')
@section('title', 'Serah Terima Surat')
@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5>Daftar Surat Siap Diambil</h5>
        <p class="text-muted">
            Pengelolaan pengambilan surat mahasiswa.
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
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
                            Belum ada surat siap diambil
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
