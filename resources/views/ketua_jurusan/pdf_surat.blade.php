<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $surat->jenis_surat }} - {{ $surat->nim }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 20px 30px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .header h3 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header h4 {
            margin: 2px 0;
            font-size: 13pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 9pt;
            font-style: italic;
        }
        .title {
            text-align: center;
            margin-bottom: 25px;
        }
        .title h4 {
            margin: 0;
            font-size: 13pt;
            text-decoration: underline;
            text-transform: uppercase;
            font-weight: bold;
        }
        .title p {
            margin: 2px 0 0 0;
            font-size: 11pt;
        }
        .content {
            text-align: justify;
            margin-bottom: 20px;
        }
        .table-data {
            margin: 15px 0 15px 30px;
            width: 90%;
        }
        .table-data td {
            padding: 3px 0;
            vertical-align: top;
        }
        .ttd-container {
            width: 100%;
            margin-top: 40px;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-image {
            height: 75px;
            margin: 5px 0;
        }
        .footer-note {
            margin-top: 130px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            font-size: 8pt;
            color: #555;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- KOP SURAT RESMI -->
    <div class="header">
        <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h3>
        <h4>FAKULTAS TEKNIK - JURUSAN {{ strtoupper($surat->jurusan ?? 'TEKNIK INFORMATIKA') }}</h4>
        <p>Jl. Kampus Terpadu No. 1, Kota Pendidikan | Telp: (021) 1234567 | Email: jurusanti@campus.ac.id</p>
    </div>

    <!-- JUDUL SURAT -->
    <div class="title">
        <h4>{{ strtoupper($surat->jenis_surat) }}</h4>
        <p>Nomor: {{ $surat->nomor_surat ?? '142/UN.FT/TI/' . date('Y') }}</p>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini Ketua Jurusan {{ $surat->jurusan ?? 'Teknik Informatika' }} Fakultas Teknik, menerangkan bahwa mahasiswa tersebut di bawah ini:</p>

        <table class="table-data">
            <tr>
                <td width="32%">Nama Lengkap</td>
                <td width="3%">:</td>
                <td><strong>{{ $surat->nama_mahasiswa }}</strong></td>
            </tr>
            <tr>
                <td>Nomor Induk Mahasiswa (NIM)</td>
                <td>:</td>
                <td><strong>{{ $surat->nim }}</strong></td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $surat->prodi }}</td>
            </tr>
            <tr>
                <td>Semester / Angkatan</td>
                <td>:</td>
                <td>Semester {{ $surat->semester ?? '6' }} / {{ $surat->angkatan ?? '2021' }}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td>{{ $surat->jurusan ?? 'Teknik Informatika' }}</td>
            </tr>
        </table>

        <p>
            Adalah benar mahasiswa yang terdaftar aktif mengikuti perkuliahan pada Jurusan {{ $surat->jurusan ?? 'Teknik Informatika' }} Fakultas Teknik pada Tahun Akademik {{ date('Y') }}/{{ date('Y') + 1 }}.
        </p>

        <p>
            Surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagai: 
            <strong>{{ $surat->keperluan }}</strong>.
        </p>

        <p>Demikian surat keterangan ini kami terbitkan untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- TANDA TANGAN KAJUR -->
    <div class="ttd-container">
        <div class="ttd-box">
            <p style="margin: 0 0 5px 0;">Ditetapkan di: Kampus</p>
            <p style="margin: 0;">Pada tanggal: {{ $surat->tanggal_disetujui ? $surat->tanggal_disetujui->translatedFormat('d F Y') : date('d F Y') }}</p>
            <p style="margin: 5px 0 0 0; font-weight: bold;">Ketua Jurusan,</p>

            <div style="min-height: 80px; padding: 5px 0;">
                @if(!empty($ttdBase64))
                    <img src="{{ $ttdBase64 }}" class="ttd-image" alt="Tanda Tangan Kajur">
                @elseif(isset($kajur) && $kajur->tanda_tangan && file_exists(storage_path('app/public/' . $kajur->tanda_tangan)))
                    @php
                        $path = storage_path('app/public/' . $kajur->tanda_tangan);
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" class="ttd-image" alt="Tanda Tangan Kajur">
                @else
                    <div style="border: 1px dashed #777; padding: 10px; font-size: 8pt; color: #444; margin: 5px auto; width: 140px;">
                        [ TTD DIGITAL TERVERIFIKASI ]<br>
                        Otentikasi Sistem Campusign
                    </div>
                @endif
            </div>

            <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                {{ $kajur->nama_lengkap ?? 'Dr. Ir. Hendra Gunawan, M.Kom.' }}
            </p>
            <p style="margin: 2px 0 0 0; font-size: 10pt;">
                NIP. {{ $kajur->nip ?? '197805122003121002' }}
            </p>
        </div>
    </div>

    <!-- FOOTER VERIFIKASI KEASLIAN -->
    <div class="footer-note">
        Dokumen ini diterbitkan secara sah dan ditandatangani secara digital melalui Sistem Administrasi Layanan Surat Jurusan (Campusign). Keabsahan dokumen dapat diverifikasi dengan Nomor Tiket: #{{ $surat->nomor_tiket }}.
    </div>
</body>
</html>

