<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f4f5f7; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f5f7; padding:20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background:#ffffff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.06); overflow:hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#206bc4; padding:20px; text-align:center;">
                            <h1 style="margin:0; font-size:22px; color:#ffffff;">
                                {{ $title }}
                            </h1>
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">
                            
                            <p style="margin-top:0;">
                                Halo <strong>{{ $user->name }}</strong>,
                            </p>

                            <p>
                                Akun Anda telah terdaftar sebagai
                                <strong>{{ $roleLabel }}</strong>.
                            </p>

                                @if(!empty($password))
                                <div style="background:#f8f9fa; border-left:4px solid #206bc4; padding:15px; border-radius:6px; margin:20px 0;">
                                    <p style="margin:0 0 10px 0;">
                                        Akun ini dibuat oleh <strong>Admin</strong>.
                                    </p>

                                    <p style="margin:0;">
                                        <strong>Email:</strong> {{ $user->email }}<br>
                                        <strong>Password:</strong> {{ $password }}
                                    </p>
                                </div>

                                <p style="font-size:14px; color:#555;">
                                    Demi keamanan, silakan login dan segera ubah kata sandi Anda.
                                </p>
                            @else
                                <p>
                                    Akun Anda berhasil dibuat. Silakan gunakan kata sandi yang Anda
                                    buat saat pendaftaran untuk mengakses sistem.
                                </p>
                            @endif

                            <!-- BUTTON -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ $url }}"
                                   style="display:inline-block; padding:14px 28px;
                                          background:#206bc4; color:#ffffff;
                                          text-decoration:none; font-weight:bold;
                                          border-radius:8px; font-size:15px;">
                                    Verifikasi Email
                                </a>
                            </div>

                            <p style="font-size:14px; color:#555;">
                                Setelah email diverifikasi, Anda dapat login ke sistem menggunakan akun Anda.
                            </p>

                            <p style="font-size:13px; color:#777;">
                                Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.
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
