<!DOCTYPE html>
<html lang="id">
<body style="
    margin:0;
    padding:0;
    background-color:#f4f6f8;
    font-family:Arial, Helvetica, sans-serif;
">

<!-- Wrapper -->
<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px 0;">
<tr>
<td align="center">

<!-- Card -->
<table width="100%" cellpadding="0" cellspacing="0" style="
    max-width:600px;
    background:#ffffff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
">

<!-- Header -->
<tr>
<td style="
    padding:24px;
    background:#0d6efd;
    color:#ffffff;
    text-align:center;
">
    <h2 style="
        margin:0;
        font-size:20px;
        font-weight:600;
    ">
        {{ $title }}
    </h2>
</td>
</tr>

<!-- Content -->
<tr>
<td style="padding:24px; color:#333333; font-size:14px; line-height:1.6">

<p style="margin-top:0">
    Halo <strong>{{ $pengajuan->nama_mahasiswa }}</strong>,
</p>

{{-- DRAFT --}}
@if($status === 'draft')
    <p>
        Pengajuan magang Anda telah <strong>berhasil diterima sistem</strong>.
    </p>
    <div style="
        background:#f8f9fa;
        padding:16px;
        border-radius:8px;
        border-left:4px solid #6c757d;
    ">
        <strong>Status: DRAFT</strong><br>
        Mohon menunggu, admin akan segera melakukan verifikasi.
    </div>

{{-- DIPROSES --}}
@elseif($status === 'diproses')
    <div style="
        background:#fff3cd;
        padding:16px;
        border-radius:8px;
        border-left:4px solid #ffc107;
    ">
        <strong> Pengajuan Sedang Diverifikasi</strong>
        <p style="margin:8px 0 0">
            Admin sedang memeriksa dokumen yang Anda kirimkan.
        </p>
    </div>

{{-- DITERIMA --}}
@elseif($status === 'diterima')
    <div style="
        background:#e6ffed;
        padding:16px;
        border-radius:8px;
        border-left:4px solid #28a745;
    ">
        <strong> Selamat! Pengajuan Anda DITERIMA</strong>
        <p style="margin:8px 0 0">
            Silakan menunggu email verifikasi akun magang untuk pembuatan password
            agar dapat login ke sistem.
        </p>
    </div>

{{-- DITOLAK --}}
@elseif($status === 'ditolak')
    <div style="
        background:#fdecea;
        padding:16px;
        border-radius:8px;
        border-left:4px solid #dc3545;
    ">
        <strong> Pengajuan Ditolak</strong>
        <p style="margin:8px 0 4px">Alasan penolakan:</p>
        <em>{{ $reason }}</em>
    </div>

{{-- SELESAI --}}
@elseif($status === 'selesai')
    <div style="
        background:#e9ecef;
        padding:16px;
        border-radius:8px;
        border-left:4px solid #0d6efd;
    ">
        <strong> Program Magang Telah Selesai</strong>
        <p style="margin:8px 0 0">
            Terima kasih telah mengikuti program magang bersama kami.
        </p>
    </div>
@endif

</td>
</tr>

<!-- Footer -->
<tr>
<td style="
    padding:16px;
    text-align:center;
    font-size:12px;
    color:#888888;
    background:#fafafa;
">
    © {{ date('Y') }} Sistem Magang<br>
    Email ini dikirim secara otomatis, mohon tidak membalas.
</td>
</tr>

</table>
<!-- End Card -->

</td>
</tr>
</table>

</body>
</html>
