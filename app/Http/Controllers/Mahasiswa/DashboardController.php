<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public const STATUS_LABELS = [
        'draft'                      => ['Draf', 'secondary'],
        'submitted'                  => ['Diajukan', 'primary'],
        'under_review'               => ['Sedang diperiksa', 'info'],
        'needs_correction'           => ['Perlu perbaikan data', 'warning'],
        'rejected'                   => ['Ditolak', 'danger'],
        'processing'                 => ['Diproses', 'info'],
        'waiting_kajur_approval'     => ['Menunggu Kajur', 'primary'],
        'revision_required'          => ['Revisi dokumen', 'warning'],
        'resubmitted'                => ['Dikirim ulang', 'primary'],
        'approved_signed'            => ['Disetujui dan ditandatangani', 'success'],
        'ready_for_pickup'           => ['Siap diambil', 'success'],
        'collected'                  => ['Telah diambil', 'secondary'],
        'expired'                    => ['Kedaluwarsa', 'dark'],
        'cancelled'                  => ['Dibatalkan', 'secondary'],
    ];

    public function index(Request $request)
    {
        $user = $request->user();
        $now  = Carbon::now()->locale('id');

        $submissions = collect([
            ['no' => 'SRT-2026-0012', 'jenis' => 'Surat Keterangan Aktif Kuliah', 'tanggal' => $now->copy()->subDays(1),  'status' => 'under_review',     'estimasi' => $now->copy()->addDays(1)],
            ['no' => 'SRT-2026-0009', 'jenis' => 'Surat Izin Penelitian',          'tanggal' => $now->copy()->subDays(3),  'status' => 'needs_correction',  'estimasi' => null],
            ['no' => 'SRT-2026-0007', 'jenis' => 'Surat Rekomendasi Beasiswa',     'tanggal' => $now->copy()->subDays(5),  'status' => 'waiting_kajur_approval', 'estimasi' => $now->copy()->addDays(1)],
            ['no' => 'SRT-2026-0003', 'jenis' => 'Surat Pengantar Magang',         'tanggal' => $now->copy()->subDays(9),  'status' => 'ready_for_pickup',  'estimasi' => null],
        ]);

        $aktif = $submissions->whereNotIn('status', ['rejected', 'collected', 'expired', 'cancelled', 'draft']);
        $ringkasan = $aktif->groupBy('status')->map->count();

        $siapDiambil = [
            ['no' => 'SRT-2026-0003', 'jenis' => 'Surat Pengantar Magang', 'batas' => $now->copy()->addDays(5)->startOfDay()],
        ];

        $notifikasi = [
            ['pesan' => 'Pengajuan SRT-2026-0009 perlu perbaikan data. Lihat catatan operator.', 'waktu' => $now->copy()->subHours(3),  'dibaca' => false],
            ['pesan' => 'Surat SRT-2026-0003 siap diambil di sekretariat jurusan.',               'waktu' => $now->copy()->subDay(),      'dibaca' => false],
            ['pesan' => 'Pengajuan SRT-2026-0012 sedang diperiksa operator.',                     'waktu' => $now->copy()->subDays(1),    'dibaca' => true],
        ];

        $pengumuman = [
            ['judul' => 'Layanan surat tutup', 'isi' => 'Layanan jurusan tutup pada libur nasional. Pengajuan tetap bisa dikirim dan dihitung hari kerja berikutnya.', 'tanggal' => $now->copy()->addDays(10)->format('d M Y')],
        ];

        return view('mahasiswa.dashboard', [
            'role'         => 'Mahasiswa',
            'user'         => $user,
            'statusLabels' => self::STATUS_LABELS,
            'submissions'  => $submissions,
            'ringkasan'    => $ringkasan,
            'totalAktif'   => $aktif->count(),
            'siapDiambil'  => $siapDiambil,
            'notifikasi'   => $notifikasi,
            'pengumuman'   => $pengumuman,
            'now'          => $now,
        ]);
    }
}
