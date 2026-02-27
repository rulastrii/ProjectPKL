<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Peserta Bimbingan</title>

    <style>
        @page {
        size: A4 portrait;
        margin: 2cm;
    }

    body {
        font-family: "Times New Roman", Times, serif;
        font-size: 12px;
        color: #000;
        margin: 0;
        padding: 0;
    }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .header-title {
            text-align: center;
        }

        .header-title h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header-title p {
            margin: 2px 0;
            font-size: 12px;
        }

        .divider {
            border-bottom: 2px solid #000;
            margin-top: 5px;
        }

        /* ===== JUDUL ===== */
        h3 {
            text-align: center;
            text-decoration: underline;
            font-size: 14px;
            margin: 20px 0 10px;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background: #f0f0f0;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        /* ===== FOOTER ===== */
        .footer {
            font-size: 11px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

@php
    $pembimbing = $siswa->pembimbingMahasiswa ?? $siswa->pembimbingPkl;
@endphp

<!-- ================= HEADER ================= -->
<table class="header-table">
    <tr>
        <td width="15%" align="left">
            <img src="{{ public_path('assets/logo-kota-cirebon.png') }}" width="70">
        </td>

        <td width="70%" class="header-title">
            <h1>DINAS KOMUNIKASI, INFORMATIKA, DAN STATISTIK</h1>
            <h1>KOTA CIREBON</h1>
            <p>Jl. Siliwangi No.1, Kota Cirebon</p>
            <p>Email: sekretariat@dkis-cirebon.go.id</p>
        </td>

        <td width="15%" align="right">
            <img src="{{ public_path('assets/logo-dkis.png') }}" width="70">
        </td>
    </tr>
    <tr>
        <td colspan="3" class="divider"></td>
    </tr>
</table>

<!-- GARIS PEMBATAS -->
<hr style="
    border: 0;
    border-top: 3px solid #000;
    margin: 15px 0 20px 0;
">

<!-- ================= JUDUL ================= -->
<h3>REKAP PESERTA BIMBINGAN</h3>

<!-- ================= DATA SISWA ================= -->
<table>
    <tr>
        <th width="200">Nama Peserta</th>
        <td>{{ $siswa->nama }}</td>
    </tr>
    <tr>
        <th>Pembimbing</th>
        <td>{{ $pembimbing?->user?->name ?? '-' }}</td>
    </tr>
</table>

<!-- ================= PRESENSI ================= -->
<h4>Rekap Presensi</h4>
<table>
    <tr>
        <th class="text-center">Hadir</th>
        <th class="text-center">Izin</th>
        <th class="text-center">Sakit</th>
        <th class="text-center">Absen</th>
    </tr>
    <tr>
        <td class="text-center">{{ $siswa->presensi->where('status','hadir')->count() }}</td>
        <td class="text-center">{{ $siswa->presensi->where('status','izin')->count() }}</td>
        <td class="text-center">{{ $siswa->presensi->where('status','sakit')->count() }}</td>
        <td class="text-center">{{ $siswa->presensi->where('status','absen')->count() }}</td>
    </tr>
</table>

<!-- ================= LAPORAN ================= -->
<h4>Laporan Harian</h4>
<table>
    <thead>
        <tr>
            <th width="120">Tanggal</th>
            <th>Ringkasan</th>
            <th width="120">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($siswa->laporan as $laporan)
        <tr>
            <td>{{ $laporan->tanggal }}</td>
            <td>{{ $laporan->ringkasan ?? '-' }}</td>
            <td>{{ ucfirst($laporan->status_verifikasi ?? '-') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">Tidak ada laporan</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- ================= TUGAS ================= -->
<h4>Tugas</h4>
<table>
    <thead>
        <tr>
            <th>Nama Tugas</th>
            <th width="100">Nilai</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($siswa->tugasSubmit as $submit)
        <tr>
            <td>{{ $submit->tugas->judul ?? '-' }}</td>
            <td class="text-center">{{ $submit->skor ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2" class="text-center">Tidak ada tugas</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- ================= FOOTER ================= -->
<div class="footer">
    Dicetak pada: {{ now()->format('d-m-Y') }} <br>
    Laporan ini dihasilkan secara otomatis oleh sistem.
</div>

</body>
</html>
