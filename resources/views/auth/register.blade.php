<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — LIBRA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; font-family: sans-serif; margin: 0; padding: 20px;">

    <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); width: 100%; max-width: 400px; box-sizing: border-box;">
        <div style="text-align: center; margin-bottom: 30px;">
            <a href="/" style="text-decoration: none; font-weight: 800; font-size: 24px; color: #1a1a1a;">
                <span style="background: #2563eb; color: white; padding: 2px 10px; border-radius: 6px; margin-right: 5px;">L</span>LIBRA<span style="color: #2563eb;">.</span>
            </a>
            <p style="color: #666; margin-top: 10px; font-size: 14px;">Daftar akun siswa perpustakaan sekolah</p>
        </div>

        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #333;">Nama Lengkap Siswa</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Fikri Malik" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #333;">Kelas</label>
                <select name="kelas" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px; background: white;">
                    <option value="" disabled selected>-- Pilih Kelas --</option>
                    <optgroup label="Kelas X">
                        <option value="X RPL 1" {{ old('kelas') == 'X RPL 1' ? 'selected' : '' }}>X RPL 1</option>
                        <option value="X RPL 2" {{ old('kelas') == 'X RPL 2' ? 'selected' : '' }}>X RPL 2</option>
                        <option value="X TKJ 1" {{ old('kelas') == 'X TKJ 1' ? 'selected' : '' }}>X TKJ 1</option>
                        <option value="X IPA 1" {{ old('kelas') == 'X IPA 1' ? 'selected' : '' }}>X IPA 1</option>
                        <option value="X IPS 1" {{ old('kelas') == 'X IPS 1' ? 'selected' : '' }}>X IPS 1</option>
                    </optgroup>
                    <optgroup label="Kelas XI">
                        <option value="XI RPL 1" {{ old('kelas') == 'XI RPL 1' ? 'selected' : '' }}>XI RPL 1</option>
                        <option value="XI RPL 2" {{ old('kelas') == 'XI RPL 2' ? 'selected' : '' }}>XI RPL 2</option>
                        <option value="XI TKJ 1" {{ old('kelas') == 'XI TKJ 1' ? 'selected' : '' }}>XI TKJ 1</option>
                        <option value="XI IPA 1" {{ old('kelas') == 'XI IPA 1' ? 'selected' : '' }}>XI IPA 1</option>
                        <option value="XI IPS 1" {{ old('kelas') == 'XI IPS 1' ? 'selected' : '' }}>XI IPS 1</option>
                    </optgroup>
                    <optgroup label="Kelas XII">
                        <option value="XII RPL 1" {{ old('kelas') == 'XII RPL 1' ? 'selected' : '' }}>XII RPL 1</option>
                        <option value="XII RPL 2" {{ old('kelas') == 'XII RPL 2' ? 'selected' : '' }}>XII RPL 2</option>
                        <option value="XII TKJ 1" {{ old('kelas') == 'XII TKJ 1' ? 'selected' : '' }}>XII TKJ 1</option>
                        <option value="XII IPA 1" {{ old('kelas') == 'XII IPA 1' ? 'selected' : '' }}>XII IPA 1</option>
                        <option value="XII IPS 1" {{ old('kelas') == 'XII IPS 1' ? 'selected' : '' }}>XII IPS 1</option>
                    </optgroup>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #333;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@sekolah.sch.id" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #333;">Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 14px;">
            </div>

            <button type="submit" style="width: 100%; background: #2563eb; color: white; padding: 14px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                Get Started
            </button>
        </form>

        <p style="text-align: center; margin-top: 25px; font-size: 14px; color: #666;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Login</a>
        </p>
    </div>

</body>
</html>