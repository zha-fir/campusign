<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

// Dashboard Ketua Jurusan
Route::get('/ketua-jurusan/dashboard', function () {
    return view('ketua_jurusan.dashboard', ['role' => 'Ketua Jurusan']);
})->middleware(['auth', 'role:ketuajurusan'])->name('ketua_jurusan.dashboard');

// Dashboard Mahasiswa
Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard', ['role' => 'Mahasiswa']);
})->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.dashboard');