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
        Pengajuan PKL Diterima
    </h2>
</td>
</tr>

<!-- Content -->
<tr>
<td style="padding:24px; color:#333333; font-size:14px; line-height:1.6">

<p style="margin-top:0">
    Halo <strong>{{ $pengajuanSiswa->nama_siswa }}</strong>,
</p>

<div style="
    background:#e6ffed;
    padding:16px;
    border-radius:8px;
    border-left:4px solid #28a745;
">
    <strong>Pengajuan PKL Anda <u>DITERIMA</u></strong>
    <p style="margin:8px 0 0">
        Periode PKL: 
        {{ \Carbon\Carbon::parse($pengajuanSiswa->pengajuan->periode_mulai)->format('d-m-Y') }} 
        s.d. 
        {{ \Carbon\Carbon::parse($pengajuanSiswa->pengajuan->periode_selesai)->format('d-m-Y') }}
    </p>
    <p style="margin:8px 0 0">
        Silakan menunggu informasi selanjutnya dari pihak sekolah/magang.
    </p>
    @if(!empty($no_surat))
    <p style="margin:8px 0 0; font-style:italic; color:#555;">
        <strong>Catatan:</strong> Surat balasan PKL Anda terlampir dalam email ini.
    </p>
    @endif
</div>

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
