<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>

    <style>
        @page {
            margin: 0;
        }

        body {
    font-family: "DejaVu Sans", serif;
    margin: 0;
    padding: 20px;
    background: linear-gradient(
        to bottom,
        #e6f0f8 0%,
        #ffffff 60%
    );
}


        /* ================= CONTAINER ================= */
        .container {
    position: relative;
    height: 175mm;
    padding: 40px;
    box-sizing: border-box;
    background: #ffffff;
    border: 6px double #0b3c5d; /* biru */
}

.container::before {
    content: "";
    position: absolute;
    top: 15px;
    left: 15px;
    right: 15px;
    bottom: 15px;
    border: 1px solid #c9a227; /* emas */
}


        /* ================= HEADER ================= */
        .header {
            margin-top: 30px;
            text-align: center;
        }

        .logo-left,
        .logo-right {
            position: absolute;
            top: 35px;
            width: 75px;
        }

        .logo-left {
            left: 45px;
        }

        .logo-right {
            right: 45px;
        }

        .title {
    font-size: 30px;
    font-weight: bold;
    letter-spacing: 4px;
    margin-bottom: 10px;
    color: #0b3c5d;
}


        .subtitle {
            font-size: 13px;
            line-height: 1.3;
        }

        /* ================= CONTENT ================= */
        .content {
            margin-top: 30px;
            padding-bottom: 55px;
            text-align: center;
            font-size: 15px;
            line-height: 1.5;
        }

        .name {
    display: inline-block;
    margin: 15px 0;
    padding-bottom: 6px;
    font-size: 26px;
    font-weight: bold;
    text-transform: uppercase;
    color: #0b3c5d;
    border-bottom: 3px solid #c9a227;
}


        .kegiatan-box,
        .lokasi-box {
            margin: 5px 0;
        }

        /* ================= FOOTER ================= */
        .footer {
    position: absolute;
    bottom: 15px;
    left: 45px;
    right: 45px;
    padding-top: 10px;
}


        .left {
            float: left;
            width: 50%;
            text-align: center;
        }

        .right {
            float: right;
            width: 30%;
            text-align: center;
        }

        .ttd img {
            height: 85px;
            margin: 8px 0;
        }

        .qr img {
            width: 100px;
        }

        .small {
            display: block;
            font-size: 11px;
        }

        .clear {
            clear: both;
        }

        p {
            margin: 6px 0;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- LOGO --}}
    <img src="{{ public_path('assets/logo-kota-cirebon.png') }}" class="logo-left" alt="Logo Kota Cirebon">
    <img src="{{ public_path('assets/logo-dkis.png') }}" class="logo-right" alt="Logo DKIS">

    {{-- HEADER --}}
    <div class="header">
        <div class="title">SERTIFIKAT</div>
        <div class="subtitle">
            Nomor Sertifikat: {{ $sertifikat->nomor_sertifikat }}<br>
            Nomor Surat: {{ $sertifikat->nomor_surat }}
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <p>Diberikan kepada:</p>

        <div class="name">
            {{ $sertifikat->siswa->nama }}
        </div>

        <div class="kegiatan-box">
            Telah menyelesaikan kegiatan<br>
            <strong>{{ strtoupper($sertifikat->judul) }}</strong>
        </div>

        <div class="lokasi-box">
            di<br>
            <strong>
                Dinas Komunikasi, Informatika dan Statistik<br>
                Kota Cirebon
            </strong>
        </div>

        <p>
            Terhitung sejak
            <strong>{{ \Carbon\Carbon::parse($sertifikat->periode_mulai)->translatedFormat('d F Y') }}</strong>
            sampai dengan
            <strong>{{ \Carbon\Carbon::parse($sertifikat->periode_selesai)->translatedFormat('d F Y') }}</strong>
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="left">
            <p>
                Cirebon,
                {{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->translatedFormat('d F Y') }}
            </p>

            <div class="ttd">
                <img src="{{ public_path('assets/ttd/kepala-dinas.png') }}" alt="Tanda Tangan">
            </div>

            <p>
                <strong>KEPALA DINAS</strong><br>
                <span class="small">
                    Dinas Komunikasi, Informatika dan Statistik
                </span>
            </p>
        </div>

        <div class="right">
            <p class="small" style="margin-bottom: 10px;">
                Scan untuk verifikasi
            </p>

            <div class="qr">
                @php
                    $qr = base64_encode(
                        QrCode::size(120)
                            ->generate(route('sertifikat.verifikasi', $sertifikat->qr_token))
                    );
                @endphp
                <img src="data:image/png;base64,{{ $qr }}" alt="QR Verifikasi">
            </div>
        </div>

        <div class="clear"></div>
    </div>

</div>

</body>
</html>
