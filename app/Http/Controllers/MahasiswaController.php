<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        return view('mahasiswa.dashboard', [
            'ringkasan'    => array_fill_keys($this->statusAktif(), 0),
            'siapDiambil'  => [],
            'pengumuman'   => [],
            'notifikasi'   => [],
            'terbaru'      => [],
            'statusLabels' => $this->statusLabels(),
        ]);
    }

    public function katalog()
    {
        return view('mahasiswa.katalog', [
            'jenisSurat' => $this->jenisSurat(),
        ]);
    }

    public function profil()
    {
        return view('mahasiswa.profil', [
            'user' => Auth::user(),
            'mhs'  => $this->dataMahasiswa(),
        ]);
    }

    public function simpanProfil(Request $request)
    {
        $request->validate(
            ['telepon' => ['required', 'regex:/^[0-9+\- ]{8,15}$/']],
            ['telepon.required' => 'Nomor telepon wajib diisi.', 'telepon.regex' => 'Nomor telepon tidak valid.']
        );

        return back()->with('sukses', 'Kontak diperbarui. (tampilan contoh, belum tersimpan)');
    }

    private function statusAktif(): array
    {
        return ['submitted', 'under_review', 'needs_correction', 'processing', 'waiting_kajur',
                'revision_required', 'resubmitted', 'approved_signed', 'ready_pickup'];
    }

    private function dataMahasiswa(): array
    {
        return [
            'nim' => '2023010004', 'jurusan' => 'Teknik Informatika', 'fakultas' => 'Fakultas Teknik',
            'angkatan' => '2023', 'telepon' => '081234567890',
        ];
    }

    private function statusLabels(): array
    {
        return [
            'draft'             => ['label' => 'Draf',                         'warna' => 'secondary'],
            'submitted'         => ['label' => 'Diajukan',                     'warna' => 'primary'],
            'under_review'      => ['label' => 'Sedang diperiksa',             'warna' => 'info'],
            'needs_correction'  => ['label' => 'Perlu perbaikan data',         'warna' => 'warning'],
            'rejected'          => ['label' => 'Ditolak',                      'warna' => 'danger'],
            'processing'        => ['label' => 'Diproses',                     'warna' => 'info'],
            'waiting_kajur'     => ['label' => 'Menunggu Kajur',               'warna' => 'secondary'],
            'revision_required' => ['label' => 'Revisi dokumen',               'warna' => 'warning'],
            'resubmitted'       => ['label' => 'Dikirim ulang',                'warna' => 'primary'],
            'approved_signed'   => ['label' => 'Disetujui dan ditandatangani', 'warna' => 'success'],
            'ready_pickup'      => ['label' => 'Siap diambil',                 'warna' => 'success'],
            'collected'         => ['label' => 'Telah diambil',                'warna' => 'dark'],
            'expired'           => ['label' => 'Kedaluwarsa',                  'warna' => 'danger'],
            'cancelled'         => ['label' => 'Dibatalkan',                   'warna' => 'secondary'],
        ];
    }

    private function jenisSurat(): array
    {
        return [
            1 => ['nama' => 'Surat keterangan aktif kuliah',                              'syarat' => [], 'sla' => null],
            2 => ['nama' => 'Surat keterangan mahasiswa',                                 'syarat' => [], 'sla' => null],
            3 => ['nama' => 'Surat izin kuliah',                                          'syarat' => [], 'sla' => null],
            4 => ['nama' => 'Surat turun lapangan, observasi, sosialisasi, atau pengambilan data', 'syarat' => [], 'sla' => null],
            5 => ['nama' => 'Surat rekomendasi (PPL, KKN, pindah, beasiswa)',             'syarat' => [], 'sla' => null],
            6 => ['nama' => 'Surat praktik mengajar atau magang',                         'syarat' => [], 'sla' => null],
            7 => ['nama' => 'Surat tugas pembimbing, seminar, dan ujian',                 'syarat' => [], 'sla' => null],
        ];
    }
}