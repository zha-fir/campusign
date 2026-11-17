<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MahasiswaController;
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