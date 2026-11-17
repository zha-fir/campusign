<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kajur extends Model
{
    use HasFactory;

    protected $table = 'kajurs';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jurusan',
        'tanda_tangan',
        'pin_persetujuan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
