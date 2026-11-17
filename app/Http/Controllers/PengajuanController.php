<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function daftarPengajuan()
{
    $pengajuan = \App\Models\PengajuanSurat::latest()->paginate(10);
    return view('admin.daftarpengajuan', compact('pengajuan'));
}
}