@extends('layouts.admin')
@section('title', 'Kelola Data Mahasiswa')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Kelola Data Mahasiswa</h4>
        <!-- Tombol Pemicu Modal Tambah -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-person-plus me-1"></i> Tambah Mahasiswa
        </button>
    </div>

    <!-- Alert Notifikasi Berhasil -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alert Notifikasi Error Validasi -->
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

    <!-- Card Tabel Data Mahasiswa -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Program Studi</th>
                            <th>Angkatan</th>
                            <th>No. WhatsApp/HP</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $index => $mhs)
                            <tr>
                                <td class="text-center">{{ $mahasiswa->firstItem() + $index }}</td>
                                <td class="fw-semibold">{{ $mhs->nim }}</td>
                                <td>{{ $mhs->nama }}</td>
                                <td>{{ $mhs->prodi }}</td>
                                <td>{{ $mhs->angkatan }}</td>
                                <td>{{ $mhs->no_hp ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Tombol Edit Modal -->
                                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $mhs->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.datamhs.destroy', $mhs->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- MODAL EDIT DATA MAHASISWA -->
                            <div class="modal fade" id="modalEdit{{ $mhs->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $mhs->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditLabel{{ $mhs->id }}">Edit Data Mahasiswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.datamhs.update', $mhs->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label class="form-label">NIM</label>
                                                    <input type="text" name="nim" class="form-control" value="{{ old('nim', $mhs->nim) }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Lengkap</label>
                                                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $mhs->nama) }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Program Studi</label>
                                                    <input type="text" name="prodi" class="form-control" value="{{ old('prodi', $mhs->prodi) }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Angkatan</label>
                                                        <input type="number" name="angkatan" class="form-control" value="{{ old('angkatan', $mhs->angkatan) }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">No. HP / WA</label>
                                                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $mhs->no_hp) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                                    Belum ada data mahasiswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($mahasiswa->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $mahasiswa->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<!-- MODAL TAMBAH DATA MAHASISWA -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Mahasiswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.datamhs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" name="nim" class="form-control" placeholder="Contoh: 20210123" value="{{ old('nim') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama mahasiswa" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <input type="text" name="prodi" class="form-control" placeholder="Contoh: Teknik Informatika" value="{{ old('prodi') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" placeholder="Contoh: 2023" value="{{ old('angkatan') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. HP / WA</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" value="{{ old('no_hp') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection