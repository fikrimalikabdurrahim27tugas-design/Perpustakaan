<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LIBRA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif; margin: 0;">

    <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); width: 100%; max-width: 400px; box-sizing: border-box;">
        <div style="text-align: center; margin-bottom: 30px;">
            <a href="/" style="text-decoration: none; font-weight: 800; font-size: 24px; color: #1a1a1a;">
                <span style="background: #2563eb; color: white; padding: 2px 10px; border-radius: 6px; margin-right: 5px;">L</span>LIBRA<span style="color: #2563eb;">.</span>
            </a>
            <p style="color: #666; margin-top: 10px; font-size: 14px;">Masuk untuk meminjam dan membaca buku</p>
        </div>

        <!-- Notifikasi Sukses Setelah Registrasi / Logout -->
        @if (session('success'))
            <div style="background: #dcfce7; border: 1px solid #22c55e; color: #15803d; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Error Login -->
        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #333;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #333;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
            </div>

            <button type="submit" style="width: 100%; background: #2563eb; color: white; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                Login
            </button>
        </form>

        <p style="text-align: center; margin-top: 25px; font-size: 14px; color: #666;">
            Belum punya akun? <a href="{{ route('register') }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Get Started</a>
        </p>
    </div>

</body>
</html>