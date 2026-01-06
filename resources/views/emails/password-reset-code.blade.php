<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:20px;">
<tr>
<td align="center">

<table width="100%" cellpadding="0" cellspacing="0"
       style="max-width:600px; background:#ffffff; border-radius:12px;
              box-shadow:0 4px 12px rgba(0,0,0,0.06); overflow:hidden;">

    <!-- HEADER -->
    <tr>
        <td style="background:#206bc4; padding:20px; text-align:center;">
            <h1 style="margin:0; font-size:22px; color:#ffffff;">
                Reset Password
            </h1>
        </td>
    </tr>

    <!-- CONTENT -->
    <tr>
        <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">

            <p style="margin-top:0;">
                Halo <strong>{{ $user->name ?? 'Pengguna' }}</strong>,
            </p>

            <p>
                Kami menerima permintaan untuk mereset password akun Anda.
            </p>

            <p>
                Gunakan kode verifikasi berikut untuk melanjutkan proses reset password:
            </p>

            <!-- RESET CODE -->
            <div style="
                font-family:'Courier New', monospace;
                font-size:26px;
                letter-spacing:6px;
                background:#f8f9fa;
                padding:18px;
                text-align:center;
                border-radius:8px;
                margin:25px 0;
                font-weight:bold;
                color:#206bc4;
            ">
                {{ $token }}
            </div>

            <p style="color:#dc3545; font-size:14px;">
                Kode ini berlaku selama <strong>15 menit</strong>.
            </p>

            <p style="font-size:13px; color:#555;">
                Jika Anda tidak merasa melakukan permintaan reset password,
                silakan abaikan email ini.
            </p>
        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="background:#f1f3f5; padding:15px; text-align:center;">
            <p style="margin:0; font-size:12px; color:#888;">
                © {{ date('Y') }} DKIS. Semua Hak Dilindungi.
            </p>
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
