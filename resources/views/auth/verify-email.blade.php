<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Arial', sans-serif;
            background-color: #f4f5f7;
            color: #212529;
        }
        a {
            color: inherit;
            text-decoration: none;
        }

        .email-wrapper {
            width: 100%;
            padding: 20px 0;
            background-color: #f4f5f7;
        }
        .email-card {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .email-header {
            background-color: #206bc4;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px 20px;
            line-height: 1.6;
            color: #212529;
        }
        .email-body h2 {
            margin-top: 0;
            font-size: 20px;
            color: #343a40;
        }

        /* Tombol outline + shadow */
        .btn {
            display: inline-block;
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #206bc4;
            background-color: transparent;
            color: #206bc4;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #206bc4;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(32,107,196,0.4);
        }

        .email-footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #868e96;
        }

        @media screen and (max-width: 600px) {
            .email-card {
                margin: 10px;
            }
            .email-header h1 {
                font-size: 20px;
            }
            .email-body h2 {
                font-size: 18px;
            }
            .btn {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-card">
            <div class="email-header">
                <h1>Verifikasi Email Anda</h1>
            </div>
            <div class="email-body">
                <h2>Halo, {{ $user->name }}!</h2>
                <p>Terima kasih telah mendaftar di <strong>DKIS</strong>. Silakan klik tombol di bawah untuk memverifikasi email Anda dan mengaktifkan akun.</p>
                <div style="text-align:center;">
                    <a href="{{ $url }}" class="btn">Verifikasi Email</a>
                </div>
                <p>Jika Anda tidak membuat akun, abaikan email ini.</p>
            </div>
            <div class="email-footer">
                Hak Cipta © {{ date('Y') }} DKIS. Semua Hak Dilindungi.
            </div>
        </div>
    </div>
</body>
</html>
