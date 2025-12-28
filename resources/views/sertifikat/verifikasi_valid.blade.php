<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Sertifikat | DKIS Kota Cirebon</title>

    {{-- SEO --}}
    <meta name="description"
          content="Halaman resmi verifikasi sertifikat Magang dan PKL Dinas Komunikasi, Informatika dan Statistik Kota Cirebon.">
    <meta name="robots" content="index, follow">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-family: "Segoe UI", sans-serif;
        }

        .card-verifikasi {
            max-width: 900px;
            margin: auto;
            border: none;
            border-top: 6px solid #198754;
        }

        .logo {
            width: 85px;
        }

        .header-title {
            font-size: 17px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .sub-title {
            font-size: 14px;
            color: #6c757d;
        }

        .table th {
            width: 35%;
            background: #f8f9fa;
        }

        .status-valid {
            font-size: 20px;
            font-weight: bold;
            color: #198754;
        }

        footer {
            font-size: 13px;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container my-5">

    <div class="card shadow card-verifikasi">
        <div class="card-body">

            {{-- HEADER --}}
            <div class="row align-items-center mb-3">
                <div class="col-md-2 text-center">
                    <img src="{{ asset('assets/logo-kota-cirebon.png') }}" class="logo">
                </div>

                <div class="col-md-8 text-center">
                    <div class="header-title">
                        DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK
                    </div>
                    <div class="sub-title">
                        Pemerintah Daerah Kota Cirebon
                    </div>
                    <div class="sub-title">
                        Jl. Dr. Sudarsono No. 40, Kota Cirebon
                    </div>
                </div>

                <div class="col-md-2 text-center">
                    <img src="{{ asset('assets/logo-dkis.png') }}" class="logo">
                </div>
            </div>

            <hr>

            {{-- STATUS --}}
            <div class="text-center mb-4">
                <div class="status-valid">SERTIFIKAT VALID</div>
                <p class="text-muted mb-0">
                    Sertifikat ini tercatat resmi dalam sistem DKIS Kota Cirebon
                </p>
            </div>

            {{-- DATA --}}
            <table class="table table-bordered">
                <tr>
                    <th>Nama Peserta</th>
                    <td>{{ $sertifikat->siswa->nama }}</td>
                </tr>
                <tr>
                    <th>Nomor Sertifikat</th>
                    <td>{{ $sertifikat->nomor_sertifikat }}</td>
                </tr>
                <tr>
                    <th>Nomor Surat</th>
                    <td>{{ $sertifikat->nomor_surat }}</td>
                </tr>
                <tr>
                    <th>Jenis Kegiatan</th>
                    <td>
                        {{ $sertifikat->siswa->user->role_id == 4
                            ? 'Praktik Kerja Lapangan (PKL)'
                            : 'Magang Mahasiswa' }}
                    </td>
                </tr>
                <tr>
                    <th>Periode Kegiatan</th>
                    <td>
                        {{ \Carbon\Carbon::parse($sertifikat->periode_mulai)->translatedFormat('d F Y') }}
                        –
                        {{ \Carbon\Carbon::parse($sertifikat->periode_selesai)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Terbit</th>
                    <td>
                        {{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->translatedFormat('d F Y') }}
                    </td>
                </tr>
            </table>

            {{-- DOWNLOAD --}}
            @if($sertifikat->file_path)
                <div class="text-center mt-4">
                    <a href="{{ asset($sertifikat->file_path) }}"
                       target="_blank"
                       class="btn btn-success px-4">
                        Unduh Sertifikat (PDF)
                    </a>
                </div>
            @endif

        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="text-center mt-4">
        Sistem Resmi Verifikasi Sertifikat Magang & PKL<br>
        © {{ date('Y') }} Dinas Komunikasi, Informatika dan Statistik Kota Cirebon
    </footer>

</div>

</body>
</html>
