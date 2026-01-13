<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f5f7; padding:20px; margin:0;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        <h2 style="margin-top:0; color:#333333; font-size:24px; text-align:center;">
            {{ $title }}
        </h2>

        <p>Halo <strong>{{ $user->name }}</strong>,</p>

        @if($status === 'approved')
            <div style="background:#e6ffed; border-left:5px solid #28a745; padding:15px; border-radius:6px; margin-bottom:20px;">
                <p style="margin:0; color:#155724; font-weight:bold;">
                    Akun guru Anda telah <span style="color:#28a745;">DISUTUJUI</span> oleh admin.
                </p>

                <p style="margin:8px 0 0 0; color:#155724;">
                    Pendaftaran Anda sebagai guru telah berhasil diverifikasi.
                </p>

                <p style="margin:8px 0 0 0; color:#155724; font-style:italic;">
                    Admin akan mengirimkan email verifikasi selanjutnya.
                    Silakan lakukan verifikasi email tersebut sebelum login ke sistem.
                </p>
            </div>

            <div style="text-align:center; margin-bottom:20px;">
                <span style="display:inline-block; background:#28a745; color:#fff; padding:12px 25px; border-radius:6px; font-weight:bold;">
                    Disetujui
                </span>
            </div>

        @elseif($status === 'rejected')
            <div style="background:#fff5f5; border-left:5px solid #dc3545; padding:15px; border-radius:6px; margin-bottom:20px;">
                <p style="margin:0; color:#721c24; font-weight:bold;">
                    Akun guru Anda <span style="color:#dc3545;">DITOLAK</span> oleh admin.
                </p>

                @if(!empty($reason))
                    <p style="margin:8px 0 0 0; color:#721c24;">
                        Alasan penolakan: <em>{{ $reason }}</em>
                    </p>
                @endif

                <p style="margin:8px 0 0 0; color:#721c24;">
                    Silakan hubungi admin jika memerlukan informasi lebih lanjut.
                </p>
            </div>

            <div style="text-align:center; margin-bottom:20px;">
                <span style="display:inline-block; background:#dc3545; color:#fff; padding:12px 25px; border-radius:6px; font-weight:bold;">
                    Ditolak
                </span>
            </div>
        @endif

        <hr style="border:none;border-top:1px solid #eee;margin:20px 0;">

        <p style="font-size:12px;color:#888; text-align:center;">
            Hak Cipta © {{ date('Y') }} DKIS. Semua Hak Dilindungi.
        </p>
    </div>
</body>
</html>
