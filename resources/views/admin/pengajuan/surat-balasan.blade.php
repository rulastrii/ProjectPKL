<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan PKL</title>
    <style>
        @page { size: A4 portrait; margin: 20mm; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            color: #000;
        }

        table.header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        table.header td { border: none; vertical-align: middle; }
        table.header img { width: 60px; height: auto; }
        table.header .title { text-align: center; }
        table.header .title h1 { margin: 0; font-size: 14pt; font-weight: bold; }
        table.header .title p { margin: 1px 0; font-size: 11pt; }

        .no-surat td { border: none; padding: 1px 0; text-align: left; }
        .right { text-align: right; }

        .content { margin: 0 30px; text-align: justify; }
        .content p { margin: 4px 0; }

        .table-data {
            width: 70%;
            margin: 5px auto;
            border-collapse: collapse;
        }
        .table-data td { border: none; padding: 2px 5px; }
        .table-data td:first-child { width: 90px; text-align: right; }
        .table-data td:last-child { text-align: left; }

        .footer-ttd { margin-top: 10px; }
        .footer-ttd .right { float: right; width: 35%; text-align: center; }
        .ttd img { height: 80px; margin: 3px 0; }
        .small { display: block; font-size: 10pt; }
        .clear { clear: both; }

        .footer-elektronik { margin-top: 135px; text-align: center; font-size: 8pt; }
    </style>
</head>
<body>

<!-- HEADER -->
<table class="header">
    <tr>
        <td width="15%" style="text-align:left;">
            <img src="{{ public_path('assets/logo-kota-cirebon.png') }}" alt="Logo Kota Cirebon">
        </td>
        <td width="70%" class="title">
            <h1>DINAS KOMUNIKASI, INFORMATIKA, DAN STATISTIK <br>(DKIS) KOTA CIREBON</h1>
            <p>Jl. Siliwangi No.1, Kesenden, Kejaksan, Kota Cirebon, Jawa Barat</p>
            <p>Telepon: (0231) 123456 | Email: sekretariat@dkis-cirebon.go.id</p>
        </td>
        <td width="15%" style="text-align:right;">
            <img src="{{ public_path('assets/logo-dkis.png') }}" alt="Logo DKIS">
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom:2px solid #000; padding:0;"></td>
    </tr>
</table>

<!-- Tanggal di kanan -->
<p class="right">Cirebon, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

<!-- NOMOR SURAT -->
<div class="no-surat">
    <table>
        <tr><td>Nomor : {{ $no_surat }}</td></tr>
        <tr><td>Sifat : Biasa</td></tr>
        <tr><td>Lampiran : -</td></tr>
        <tr><td>Hal : Penerimaan Praktik Kerja Lapangan</td></tr>
    </table>

    <p>
        Yth. Kepala Sekolah<br>
        {{ $pengajuan->sekolah->nama ?? '-' }}<br>
        di Tempat
    </p>
</div>

<!-- ISI SURAT -->
<div class="content">
    <p>
        Menindaklanjuti Surat Kepala Sekolah {{ $pengajuan->sekolah->nama ?? '-' }}
        Nomor: {{ $pengajuan->no_surat }} tanggal {{ \Carbon\Carbon::parse($pengajuan->tgl_surat)->translatedFormat('d F Y') }} hal Permohonan PKL, 
        dengan ini kami sampaikan bahwa usulan siswa berikut:
    </p>

    <table class="table-data">
         <tr><td>Nama</td><td>: {{ $siswa->nama_siswa }}</td></tr>
        <tr><td>Email</td><td>: {{ $siswa->email_siswa }}</td></tr>
    </table>

    <p>
        Dapat kami terima untuk melaksanakan PKL di lingkungan Dinas Komunikasi, Informatika dan Statistik Kota Cirebon
        yang dilaksanakan pada tanggal {{ \Carbon\Carbon::parse($pengajuan->periode_mulai)->format('d F Y') }} s.d. {{ \Carbon\Carbon::parse($pengajuan->periode_selesai)->translatedFormat('d F Y') }}.
    </p>

    <p>Atas perhatiannya kami ucapkan terimakasih.</p>
</div>

<!-- TANDA TANGAN -->
<div class="footer-ttd">
    <div class="right">
        <p class="small">
            Kepala Dinas Komunikasi,<br>
            Informatika, dan Statistik Kota Cirebon,
        </p>
        <div class="ttd">
            <img src="{{ public_path('assets/ttd/kepala-dinas.png') }}" alt="Tanda Tangan">
        </div>
        <p class="small" style="margin-top:3px;">
            {{ $ttd }}<br>
            NIP. 197603301996021004
        </p>
    </div>
    <div class="clear"></div>
</div>

<!-- FOOTER ELEKTRONIK -->
<div class="footer-elektronik">
    Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan oleh Balai Besar Sertifikasi Elektronik (BSrE),
    Badan Siber dan Sandi Negara (BSSN)
</div>

</body>
</html>
