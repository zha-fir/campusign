<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KetuaJurusanController;
use App\Http\Controllers\PengajuanController;

Route::get('/', function () {
    return view('welcome');
});


// Halaman login
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])
        ->name('login.authenticate');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard', ['role' => 'Admin']);
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Dashboard Operator
Route::get('/operator/dashboard', function () {
    return view('operator.dashboard', ['role' => 'Operator']);
})->middleware(['auth', 'role:operator'])->name('operator.dashboard');

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