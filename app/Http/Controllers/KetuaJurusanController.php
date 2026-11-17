<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kajur;
use App\Models\PengajuanSurat;

class KetuaJurusanController extends Controller
{
    /**
     * Mengambil profil data Ketua Jurusan yang sedang login.
     * Jika belum ada di tabel kajurs, otomatis dibuatkan data awal.
     */
    private function getKajur()
    {
        $kajur = Kajur::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'nip'          => '197805122003121002',
                'nama_lengkap' => auth()->user()?->name ?? 'Dr. Ir. Hendra Gunawan, M.Kom.',
                'jurusan'      => 'Teknik Informatika',
            ]
        );

        if (empty($kajur->jurusan)) {
            $kajur->jurusan = 'Teknik Informatika';
        }

        return $kajur;
    }

    /**
     * 1. Dashboard Kajur
     * Menampilkan statistik ringkasan dan 5 antrean surat terbaru.
     */
    public function dashboard()
    {
        $kajur = $this->getKajur();

        // Query dasar pengajuan surat khusus jurusan kajur
        $baseQuery = PengajuanSurat::where('jurusan', $kajur->jurusan);

        $statistik = [
            'dokumen_menunggu'  => (clone $baseQuery)->whereIn('status', ['menunggu', 'dikirim_ulang'])->count(),
            'dokumen_disetujui' => (clone $baseQuery)->where('status', 'disetujui')->count(),
            'dokumen_revisi'    => (clone $baseQuery)->where('status', 'revisi')->count(),
            'rata_waktu_proses' => '1.5 Hari',
        ];

        $antreanTerbaru = (clone $baseQuery)
            ->whereIn('status', ['menunggu', 'dikirim_ulang'])
            ->latest()
            ->take(5)
            ->get();

        return view('ketua_jurusan.dashboard', compact('statistik', 'antreanTerbaru', 'kajur'));
    }

    /**
     * 2. Daftar Antrean Persetujuan
     * Menampilkan daftar surat yang menunggu persetujuan dengan fitur filter.
     */
    public function antrean(Request $request)
    {
        $kajur = $this->getKajur();

        $daftarAntrean = PengajuanSurat::where('jurusan', $kajur->jurusan)
            ->whereIn('status', ['menunggu', 'dikirim_ulang'])
            ->when($request->filled('jenis_surat'), fn($q) => $q->where('jenis_surat', 'like', "%{$request->jenis_surat}%"))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('tanggal'), fn($q) => $q->whereDate('created_at', $request->tanggal))
            ->latest()
            ->paginate(10);

        return view('ketua_jurusan.antrean', compact('daftarAntrean', 'kajur'));
    }

    /**
     * 3. Persetujuan Massal (Bulk Approve)
     * Menyetujui beberapa surat sekaligus menggunakan verifikasi PIN 6 digit.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate(['pin' => 'required|digits:6'], [
            'pin.required' => 'PIN tanda tangan wajib diisi.',
            'pin.digits'   => 'PIN tanda tangan harus berupa 6 digit angka.',
        ]);

        $kajur = $this->getKajur();

        // Validasi PIN keamanan
        if ($kajur->pin_persetujuan && !Hash::check($request->pin, $kajur->pin_persetujuan)) {
            return back()->with('error', 'PIN tanda tangan yang Anda masukkan salah!');
        }

        // Update status pengajuan yang dipilih menjadi 'disetujui'
        $count = PengajuanSurat::where('jurusan', $kajur->jurusan)
            ->whereIn('status', ['menunggu', 'dikirim_ulang'])
            ->when($request->filled('selected_ids'), fn($q) => $q->whereIn('id', $request->selected_ids))
            ->update([
                'status'            => 'disetujui',
                'kajur_id'          => $kajur->id,
                'tanggal_disetujui' => now(),
            ]);

        return redirect()->route('ketua_jurusan.riwayat')
            ->with('success', "Sebanyak {$count} dokumen berhasil disetujui dan ditandatangani secara massal!");
    }

    /**
     * 4. Halaman Peninjauan Surat
     * Membuka dokumen surat berdasarkan ID, atau surat pertama dalam antrean.
     */
    public function peninjauan($id = null)
    {
        $kajur = $this->getKajur();

        $surat = $id
            ? PengajuanSurat::where('jurusan', $kajur->jurusan)->findOrFail($id)
            : PengajuanSurat::where('jurusan', $kajur->jurusan)
                ->whereIn('status', ['menunggu', 'dikirim_ulang'])
                ->first() ?? PengajuanSurat::where('jurusan', $kajur->jurusan)->latest()->first();

        return view('ketua_jurusan.peninjauan', compact('surat', 'kajur'));
    }

    /**
     * 5. Setujui dan Tanda Tangani Satu Dokumen
     * Menyetujui satu surat dengan verifikasi PIN 6 digit.
     */
    public function setujui(Request $request, $id)
    {
        $request->validate(['pin' => 'required|digits:6'], [
            'pin.required' => 'PIN tanda tangan wajib diisi.',
            'pin.digits'   => 'PIN tanda tangan harus berupa 6 digit angka.',
        ]);

        $kajur = $this->getKajur();

        // Validasi PIN keamanan
        if ($kajur->pin_persetujuan && !Hash::check($request->pin, $kajur->pin_persetujuan)) {
            return back()->with('error', 'PIN tanda tangan salah! Silakan periksa kembali PIN Anda.');
        }

        $surat = PengajuanSurat::findOrFail($id);
        $surat->update([
            'status'            => 'disetujui',
            'kajur_id'          => $kajur->id,
            'tanggal_disetujui' => now(),
        ]);

        return redirect()->route('ketua_jurusan.riwayat')
            ->with('success', "Dokumen surat #{$surat->nomor_tiket} ({$surat->nama_mahasiswa}) berhasil disetujui & ditandatangani! File PDF resmi siap diunduh.");
    }

    /**
     * 6. Minta Revisi Dokumen
     * Mengembalikan surat ke pemohon disertai catatan perbaikan.
     */
    public function mintaRevisi(Request $request, $id)
    {
        $request->validate(['catatan_revisi' => 'required|string|min:5'], [
            'catatan_revisi.required' => 'Catatan revisi wajib diisi agar pemohon mengetahui hal yang perlu diperbaiki.',
            'catatan_revisi.min'      => 'Catatan revisi minimal 5 karakter.',
        ]);

        $surat = PengajuanSurat::findOrFail($id);
        $surat->update([
            'status'         => 'revisi',
            'catatan_revisi' => $request->catatan_revisi,
        ]);

        return redirect()->route('ketua_jurusan.antrean')
            ->with('success', "Permintaan revisi untuk surat #{$surat->nomor_tiket} berhasil dikirim kembali ke pemohon.");
    }

    /**
     * 7. Riwayat Surat yang Telah Disetujui
     * Menampilkan riwayat persetujuan dengan fitur pencarian tiket/nama/nim.
     */
    public function riwayat(Request $request)
    {
        $kajur = $this->getKajur();

        $daftarRiwayat = PengajuanSurat::where('jurusan', $kajur->jurusan)
            ->where('status', 'disetujui')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = "%{$request->q}%";
                $query->where(function ($q) use ($keyword) {
                    $q->where('nomor_tiket', 'like', $keyword)
                      ->orWhere('nama_mahasiswa', 'like', $keyword)
                      ->orWhere('nim', 'like', $keyword);
                });
            })
            ->latest('tanggal_disetujui')
            ->paginate(10);

        return view('ketua_jurusan.riwayat', compact('daftarRiwayat', 'kajur'));
    }

    /**
     * 8. Unduh Berkas PDF Surat Resmi
     * Mengonversi dokumen surat beserta tanda tangan digital ke format PDF.
     */
    public function unduhPdf($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $kajur = $surat->kajur ?? $this->getKajur();

        // Encode gambar spesimen tanda tangan ke format base64 agar terbaca oleh DOMPDF
        $ttdBase64 = null;
        if ($kajur?->tanda_tangan && Storage::disk('public')->exists($kajur->tanda_tangan)) {
            $file = Storage::disk('public')->get($kajur->tanda_tangan);
            $mime = Storage::disk('public')->mimeType($kajur->tanda_tangan);
            $ttdBase64 = "data:{$mime};base64," . base64_encode($file);
        }

        $pdf = Pdf::loadView('ketua_jurusan.pdf_surat', compact('surat', 'kajur', 'ttdBase64'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download("Surat-{$surat->nomor_tiket}-{$surat->nim}.pdf");
    }

    /**
     * 9. Pengaturan Tanda Tangan (Tampilan)
     */
    public function pengaturanTtd()
    {
        $kajur = $this->getKajur();
        return view('ketua_jurusan.pengaturan_ttd', compact('kajur'));
    }

    /**
     * Fallback handler router untuk form pengaturan tanda tangan
     */
    public function savePengaturanTtd(Request $request)
    {
        return $request->hasFile('spesimen')
            ? $this->updateSpesimen($request)
            : $this->updatePin($request);
    }

    /**
     * 10. Perbarui PIN Persetujuan Tanda Tangan
     */
    public function updatePin(Request $request)
    {
        $request->validate([
            'pin_baru'       => 'required|digits:6',
            'konfirmasi_pin' => 'required|same:pin_baru',
        ], [
            'pin_baru.required'       => 'PIN baru wajib diisi.',
            'pin_baru.digits'         => 'PIN harus terdiri dari 6 digit angka.',
            'konfirmasi_pin.required' => 'Konfirmasi PIN wajib diisi.',
            'konfirmasi_pin.same'     => 'Konfirmasi PIN tidak cocok dengan PIN baru.',
        ]);

        $this->getKajur()->update([
            'pin_persetujuan' => Hash::make($request->pin_baru)
        ]);

        return redirect()->route('ketua_jurusan.pengaturan_ttd')
            ->with('success', 'PIN persetujuan tanda tangan berhasil diperbarui!');
    }

    /**
     * 11. Unggah Gambar Spesimen Tanda Tangan
     */
    public function updateSpesimen(Request $request)
    {
        $request->validate([
            'spesimen' => 'required|image|mimes:png|max:2048',
        ], [
            'spesimen.required' => 'File spesimen tanda tangan wajib dipilih.',
            'spesimen.image'    => 'File harus berupa gambar.',
            'spesimen.mimes'    => 'Format gambar harus berupa file .PNG transparan.',
            'spesimen.max'      => 'Ukuran file tanda tangan maksimal 2MB.',
        ]);

        $kajur = $this->getKajur();

        // Hapus file spesimen fisik lama jika ada agar penyimpanan tetap bersih
        if ($kajur->tanda_tangan && Storage::disk('public')->exists($kajur->tanda_tangan)) {
            Storage::disk('public')->delete($kajur->tanda_tangan);
        }

        $path = $request->file('spesimen')->store('spesimen_ttd', 'public');
        $kajur->update(['tanda_tangan' => $path]);

        return redirect()->route('ketua_jurusan.pengaturan_ttd')
            ->with('success', 'Spesimen tanda tangan digital berhasil diperbarui!');
    }
}
