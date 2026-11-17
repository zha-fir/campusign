<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surats';

    protected $fillable = [
        'nomor_tiket',
        'nomor_surat',
        'nama_mahasiswa',
        'nim',
        'prodi',
        'jurusan',
        'semester',
        'angkatan',
        'no_hp',
        'jenis_surat',
        'keperluan',
        'lampiran',
        'status',
        'catatan_revisi',
        'kajur_id',
        'tanggal_disetujui',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_disetujui' => 'datetime',
        ];
    }

    public function kajur()
    {
        return $this->belongsTo(Kajur::class);
    }
}
