<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengajuanSurat;

class PengajuanSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (PengajuanSurat::count() == 0) {
            PengajuanSurat::create([
                'nomor_tiket'     => 'SRT-2026-001',
                'nomor_surat'     => '142/UN.FT/TI/2026',
                'nama_mahasiswa'  => 'Ahmad Fauzi',
                'nim'             => '2021081001',
                'prodi'           => 'Teknik Informatika (S1)',
                'jurusan'         => 'Teknik Informatika',
                'semester'        => '6',
                'angkatan'        => '2021',
                'no_hp'           => '081234567890',
                'jenis_surat'     => 'Surat Keterangan Aktif Kuliah',
                'keperluan'       => 'Kelengkapan Berkas Beasiswa Pendidikan Prestasi',
                'status'          => 'menunggu',
                'created_at'      => now()->subHours(3),
            ]);

            PengajuanSurat::create([
                'nomor_tiket'     => 'SRT-2026-002',
                'nomor_surat'     => '143/UN.FT/TI/2026',
                'nama_mahasiswa'  => 'Siti Aminah',
                'nim'             => '2021081045',
                'prodi'           => 'Sistem Informasi (S1)',
                'jurusan'         => 'Teknik Informatika',
                'semester'        => '6',
                'angkatan'        => '2021',
                'no_hp'           => '081298765432',
                'jenis_surat'     => 'Surat Izin Penelitian / PKL',
                'keperluan'       => 'Izin Pengambilan Data Tugas Akhir di Dinas Kominfo',
                'status'          => 'dikirim_ulang',
                'catatan_revisi'  => 'Lampirkan surat permohonan dari instansi terkait.',
                'created_at'      => now()->subHours(5),
            ]);

            PengajuanSurat::create([
                'nomor_tiket'     => 'SRT-2026-003',
                'nomor_surat'     => '144/UN.FT/TI/2026',
                'nama_mahasiswa'  => 'Bambang Pamungkas',
                'nim'             => '2022081019',
                'prodi'           => 'Teknik Informatika (S1)',
                'jurusan'         => 'Teknik Informatika',
                'semester'        => '4',
                'angkatan'        => '2022',
                'no_hp'           => '081377889900',
                'jenis_surat'     => 'Surat Rekomendasi Magang MBKM',
                'keperluan'       => 'Pendaftaran Program Magang Bersertifikat Kemendikbudristek',
                'status'          => 'menunggu',
                'created_at'      => now()->subHours(1),
            ]);

            PengajuanSurat::create([
                'nomor_tiket'     => 'SRT-2026-000',
                'nomor_surat'     => '140/UN.FT/TI/2026',
                'nama_mahasiswa'  => 'Rian Pratama',
                'nim'             => '2021081012',
                'prodi'           => 'Teknik Informatika (S1)',
                'jurusan'         => 'Teknik Informatika',
                'semester'        => '6',
                'angkatan'        => '2021',
                'no_hp'           => '081211223344',
                'jenis_surat'     => 'Surat Izin Penelitian / Tugas Akhir',
                'keperluan'       => 'Penelitian Algoritma Machine Learning',
                'status'          => 'disetujui',
                'tanggal_disetujui' => now()->subDay(),
                'created_at'      => now()->subDays(2),
            ]);
        }
    }
}