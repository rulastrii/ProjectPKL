<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f5f7; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        <h2 style="margin-top:0; color:#333333; font-size:24px; text-align:center;">{{ $title }}</h2>

        <p>Halo <strong>{{ $user->name }}</strong>,</p>

        <p>Anda terdaftar sebagai <strong>{{ $roleLabel }}</strong>.</p>

        @if($isAdminCreated)
            <p>Akun Anda telah dibuat oleh admin.</p>
            <p>
                <strong>Email:</strong> {{ $user->email }}<br>
                @if(!empty($password))
                    <strong>Password:</strong> {{ $password }}
                @endif
            </p>
        @else
            <p>Akun Anda telah berhasil dibuat. Silakan gunakan kata sandi yang telah Anda tetapkan saat pendaftaran untuk mengakses sistem.</p>
        @endif

        <p style="text-align:center; margin:20px 0;">
            <a href="{{ $url }}" style="display:inline-block; padding:12px 25px; background:#206bc4; color:#fff; border-radius:6px; font-weight:bold; text-decoration:none;">
                Verifikasi Email
            </a>
        </p>

        <p>Setelah verifikasi, silakan login ke sistem.</p>

        <hr style="border:none;border-top:1px solid #eee;margin:20px 0;">
        <p style="font-size:12px;color:#888; text-align:center;">
            Hak Cipta © {{ date('Y') }} DKIS. Semua Hak Dilindungi.
        </p>
    </div>
</body>
</html>
