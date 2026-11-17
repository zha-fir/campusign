@extends('operator.layout')
@section('title', 'Editor Surat')
@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5>Form Pembuatan Surat</h5>
        <p class="text-muted">
            Tampilan awal penyusunan surat mahasiswa.
        </p>

        <div class="mb-3">
            <label class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control"
                   placeholder="Masukkan nama mahasiswa">
        </div>

        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" class="form-control"
                   placeholder="Masukkan NIM">
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Surat</label>
            <select class="form-select">
                <option value="">Pilih jenis surat</option>
                <option>Surat Aktif Kuliah</option>
                <option>Surat Turun Lapangan</option>
                <option>Surat Permohonan Cuti Akademik</option>
                <option>Surat Izin Penelitian</option>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Isi Surat</label>
            <textarea class="form-control" rows="5"
                      placeholder="Masukkan isi surat"></textarea>
        </div>

        <button type="button" class="btn btn-primary" disabled>
            Simpan Surat
        </button>

    </div>
</div>

@endsection
