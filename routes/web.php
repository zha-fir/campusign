<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KetuaJurusanController;
use App\Http\Controllers\PengajuanController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])
        ->name('login.authenticate');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', ['role' => 'Admin']);
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Dashboard Operator
Route::middleware(['auth', 'role:operator'])
    ->prefix('operator')
    ->name('operator.')
    ->controller(\App\Http\Controllers\Operator\OperatorPageController::class)
    ->group(function () {

        Route::get('/dashboard', 'dashboard')
            ->name('dashboard');

        Route::get('/verifikasi-berkas', 'verifikasi')
            ->name('verifikasi');

        Route::get('/editor-surat', 'editor')
            ->name('editor');

        Route::get('/serah-terima', 'serahTerima')
            ->name('serahTerima');
    });

// Modul Ketua Jurusan (Kajur - 5 Menu)
Route::middleware(['auth', 'role:ketuajurusan'])->prefix('ketua-jurusan')->name('ketua_jurusan.')->group(function () {
    Route::get('/dashboard', [KetuaJurusanController::class, 'dashboard'])->name('dashboard');
    Route::get('/antrean', [KetuaJurusanController::class, 'antrean'])->name('antrean');
    Route::post('/antrean/bulk', [KetuaJurusanController::class, 'bulkApprove'])->name('antrean.bulk');
    Route::get('/peninjauan/{id?}', [KetuaJurusanController::class, 'peninjauan'])->name('peninjauan');
    Route::post('/peninjauan/{id}/setujui', [KetuaJurusanController::class, 'setujui'])->name('peninjauan.setujui');
    Route::post('/peninjauan/{id}/revisi', [KetuaJurusanController::class, 'mintaRevisi'])->name('peninjauan.revisi');
    Route::get('/unduh-pdf/{id}', [KetuaJurusanController::class, 'unduhPdf'])->name('unduh_pdf');
    Route::get('/riwayat', [KetuaJurusanController::class, 'riwayat'])->name('riwayat');
    Route::get('/pengaturan-ttd', [KetuaJurusanController::class, 'pengaturanTtd'])->name('pengaturan_ttd');
    Route::post('/pengaturan-ttd', [KetuaJurusanController::class, 'savePengaturanTtd'])->name('pengaturan_ttd.save');
    Route::post('/pengaturan-ttd/pin', [KetuaJurusanController::class, 'updatePin'])->name('pengaturan_ttd.pin');
    Route::post('/pengaturan-ttd/spesimen', [KetuaJurusanController::class, 'updateSpesimen'])->name('pengaturan_ttd.spesimen');
});

// Dashboard Mahasiswa
Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard', ['role' => 'Mahasiswa']);
})->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.dashboard');

// Kelola Data Mahasiswa & Pengajuan (CRUD Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/daftarpengajuan', [PengajuanController::class, 'daftarPengajuan'])->name('daftarpengajuan');

    Route::get('/datamhs', [MahasiswaController::class, 'index'])->name('datamhs');
    Route::post('/datamhs', [MahasiswaController::class, 'store'])->name('datamhs.store');
    Route::put('/datamhs/{id}', [MahasiswaController::class, 'update'])->name('datamhs.update');
    Route::delete('/datamhs/{id}', [MahasiswaController::class, 'destroy'])->name('datamhs.destroy');
});
Route::get('/operator/dashboard', function () {
    return view('operator.dashboard', ['role' => 'Operator']);
})->middleware(['auth', 'role:operator'])->name('operator.dashboard');

Route::get('/ketua-jurusan/dashboard', function () {
    return view('ketua_jurusan.dashboard', ['role' => 'Ketua Jurusan']);
})->middleware(['auth', 'role:ketuajurusan'])->name('ketua_jurusan.dashboard');

Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/katalog', [MahasiswaController::class, 'katalog'])->name('katalog');
        Route::get('/profil', [MahasiswaController::class, 'profil'])->name('profil');
        Route::post('/profil', [MahasiswaController::class, 'simpanProfil'])->name('profil.simpan');
    });
