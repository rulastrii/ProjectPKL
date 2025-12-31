<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        /* Header resmi dengan dua logo */
        .header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .logo-left, .header .logo-right {
            width: 80px;
        }

        .header .logo-left img, .header .logo-right img {
            width: 80px;
            height: auto;
        }

        .header .title {
            text-align: center;
            flex-grow: 1;
            margin: 0 15px;
        }

        .header .title h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header .title p {
            margin: 2px 0;
            font-size: 12px;
        }

        /* Judul laporan */
        h3 {
            text-align: center;
            text-decoration: underline;
            font-size: 14px;
            margin-bottom: 5px;
        }

        p.period {
            text-align: center;
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        /* Table polos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            font-weight: bold;
        }

        td.text-left {
            text-align: left;
        }

        /* Footer catatan */
        .footer {
            font-size: 11px;
            text-align: left;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- HEADER DENGAN TABEL TANPA OUTLINE SAMPING/ATAS -->
<table width="100%" style="border-collapse: collapse; margin-bottom:20px;">
    <tr>
        <!-- Logo kiri -->
        <td width="15%" style="text-align:left; vertical-align:middle; border:none;">
            <img src="{{ public_path('assets/logo-kota-cirebon.png') }}" alt="Logo Kota Cirebon" style="width:60px; height:auto;">
        </td>

        <!-- Judul tengah -->
        <td width="70%" style="text-align:center; vertical-align:middle; border:none;">
            <h1 style="margin:0; font-size:16px; font-weight:bold;">
                DINAS KOMUNIKASI, INFORMATIKA, DAN STATISTIK <br> (DKIS) KOTA CIREBON
            </h1>
            <p style="margin:2px 0; font-size:12px;">
                Jl. Siliwangi No.1, Kesenden, Kejaksan, Kota Cirebon, Jawa Barat
            </p>
            <p style="margin:2px 0; font-size:12px;">
                Telepon: (0231) 123456 | Email: sekretariat@dkis-cirebon.go.id
            </p>
        </td>

        <!-- Logo kanan -->
        <td width="15%" style="text-align:right; vertical-align:middle; border:none;">
            <img src="{{ public_path('assets/logo-dkis.png') }}" alt="Logo DKIS" style="width:60px; height:auto;">
        </td>
    </tr>

    <!-- Garis bawah header -->
    <tr>
        <td colspan="3" style="border-bottom:2px solid #000; padding:0;"></td>
    </tr>
</table>


<!-- Judul Laporan -->
<h3>LAPORAN REKAP PRESENSI PESERTA PKL & MAGANG</h3>
<p class="period">Periode {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</p>

<!-- Table Rekap -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Nama</th>
            <th>Jenis</th>
            <th>Bidang</th>
            <th>Pembimbing</th>
            <th>H</th>
            <th>I</th>
            <th>S</th>
            <th>A</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekap as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td class="text-left">{{ $row['nama'] }}</td>
            <td>{{ $row['jenis'] }}</td>
            <td>{{ $row['bidang'] }}</td>
            <td>{{ $row['pembimbing'] }}</td>
            <td>{{ $row['hadir'] }}</td>
            <td>{{ $row['izin'] }}</td>
            <td>{{ $row['sakit'] }}</td>
            <td>{{ $row['absen'] }}</td>
            <td>{{ $row['total'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Laporan ini dibuat secara otomatis oleh Sistem Informasi DKIS Kota Cirebon.
</div>

</body>
</html>
