@extends('layouts.mahasiswa')

@section('title', 'Profil akun')

@section('content')

<h1 class="h3 fw-bold mb-4">Profil akun</h1>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Data diri dan kontak</div>
            <div class="card-body">

                <form onsubmit="return false;">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" value="{{ $mhs['nim'] }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Angkatan</label>
                            <input type="text" class="form-control" value="{{ $mhs['angkatan'] }}" disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan / prodi</label>
                        <input type="text" class="form-control" value="{{ $mhs['jurusan'] }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fakultas</label>
                        <input type="text" class="form-control" value="{{ $mhs['fakultas'] }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label fw-semibold">Nomor telepon / WhatsApp</label>
                        <input type="text" name="telepon" id="telepon" class="form-control"
                               value="{{ $mhs['telepon'] }}">
                    </div>
                    <button type="button" class="btn btn-primary">Simpan kontak</button>
                </form>

            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Ganti password</div>
            <div class="card-body">
                    <div class="mb-3">
                        <label for="lama" class="form-label">Password lama</label>
                        <input type="password" name="lama" id="lama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="baru" class="form-label">Password baru</label>
                        <input type="password" name="baru" id="baru" class="form-control">
                        <div class="form-text">Minimal 8 karakter.</div>
                    </div>
                    <div class="mb-3">
                        <label for="baru_confirmation" class="form-label">Ulangi password baru</label>
                        <input type="password" name="baru_confirmation" id="baru_confirmation" class="form-control">
                    </div>
                    <button type="button" class="btn btn-primary">Ganti password</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection