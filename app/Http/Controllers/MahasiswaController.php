<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    // Menampilkan daftar mahasiswa
    public function index()
    {
        $mahasiswa = Mahasiswa::latest()->paginate(10);
        return view('admin.datamhs', compact('mahasiswa'));
    }
    // Menyimpan data mahasiswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nim'      => 'required|unique:mahasiswas,nim',
            'nama'     => 'required|string|max:255',
            'prodi'    => 'required|string|max:100',
            'angkatan' => 'required|numeric|digits:4',
            'no_hp'    => 'nullable|string|max:20',
        ]);
        Mahasiswa::create($request->all());
        return redirect()->route('admin.datamhs')->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }
    // Memperbarui data mahasiswa
    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $request->validate([
            'nim'      => 'required|unique:mahasiswas,nim,' . $mhs->id,
            'nama'     => 'required|string|max:255',
            'prodi'    => 'required|string|max:100',
            'angkatan' => 'required|numeric|digits:4',
            'no_hp'    => 'nullable|string|max:20',
        ]);
        $mhs->update($request->all());
        return redirect()->route('admin.datamhs')->with('success', 'Data mahasiswa berhasil diperbarui!');
    }
    // Menghapus data mahasiswa
    public function destroy($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->delete();
        return redirect()->route('admin.datamhs')->with('success', 'Data mahasiswa berhasil dihapus!');
    }
}