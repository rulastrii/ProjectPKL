<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f5f7; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:20px; border-radius:8px;">
        <h2 style="margin-top:0;">{{ $title }}</h2>

        <p>Halo <strong>{{ $user->name }}</strong>,</p>

        <p>
            Anda terdaftar sebagai
            <strong>{{ $roleLabel }}</strong>.
        </p>

        <p>Akun Anda telah dibuat oleh admin.</p>

        <p>
            <strong>Email:</strong> {{ $user->email }}<br>
            @if(!empty($password))
                <strong>Password:</strong> {{ $password }}
            @endif
        </p>

        <p>
            Silakan klik tombol di bawah ini untuk melakukan verifikasi email:
        </p>

        <p style="text-align:center;">
            <a href="{{ $url }}"
               style="display:inline-block;
                      padding:12px 20px;
                      background:#206bc4;
                      color:#ffffff;
                      border-radius:6px;
                      text-decoration:none;">
                Verifikasi Email
            </a>
        </p>

        <p>Setelah email terverifikasi, silakan login ke sistem.</p>

        <hr style="border:none;border-top:1px solid #eee;margin:20px 0;">

        <p style="font-size:12px;color:#888;">
            © {{ date('Y') }} DKIS
        </p>
    </div>
</body>
</html>
