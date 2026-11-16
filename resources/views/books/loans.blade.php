<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjaman Saya — LIBRA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: #f8fafc; font-family: sans-serif; margin: 0; color: #1e293b;">

    <!-- NAVBAR -->
    <header style="background: white; border-bottom: 1px solid #e2e8f0; padding: 16px 0;">
        <div style="max-width: 1140px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('home') }}" style="text-decoration: none; font-weight: 800; font-size: 22px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <span style="background: #2563eb; color: white; padding: 2px 10px; border-radius: 6px;">L</span>
                <span>LIBRA<span style="color: #2563eb;">.</span></span>
            </a>

            <div style="display: flex; align-items: center; gap: 18px;">
                <a href="{{ route('home') }}" style="text-decoration: none; color: #475569; font-weight: 600; font-size: 14px;">Beranda</a>
                <a href="{{ route('books.index') }}" style="text-decoration: none; color: #475569; font-weight: 600; font-size: 14px;">Katalog Buku</a>
                <a href="{{ route('loans.index') }}" style="text-decoration: none; color: #2563eb; font-weight: 700; font-size: 14px;">Pinjaman Saya</a>

                <div style="background: #eff6ff; padding: 6px 14px; border-radius: 99px; border: 1px solid #bfdbfe; font-size: 13px; font-weight: 600; color: #1e3a8a;">
                    {{ Auth::user()->name }}
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 7px 14px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <div style="margin-bottom: 24px;">
            <h1 style="margin: 0; font-size: 26px; color: #0f172a;">Daftar Pinjaman Buku Saya</h1>
            <p style="margin: 6px 0 0; color: #64748b; font-size: 14px;">
    Kartu Peminjam: <strong>{{ Auth::user()->name }}</strong> — Kelas <strong>{{ Auth::user()->kelas ?? '-' }}</strong> ({{ Auth::user()->email }})
</p>
        </div>

        <!-- Peringatan Tunggakan Denda -->
        @if($totalUnpaidFine > 0)
            <div style="background: #fef2f2; border: 1px solid #f87171; color: #991b1b; padding: 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                <strong>🚨 Peringatan Denda:</strong> Anda memiliki total denda keterlambatan sebesar <strong>Rp {{ number_format($totalUnpaidFine, 0, ',', '.') }}</strong>. Anda tidak dapat meminjam buku baru sebelum melunasi denda ke petugas perpustakaan.
            </div>
        @endif

        @if (session('success'))
            <div style="background: #dcfce7; border: 1px solid #22c55e; color: #15803d; padding: 14px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div style="background: #fef3c7; border: 1px solid #f59e0b; color: #b45309; padding: 14px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;">
            @if($loans->isEmpty())
                <div style="padding: 50px; text-align: center;">
                    <p style="color: #64748b; margin-bottom: 16px;">Anda belum memiliki riwayat peminjaman buku.</p>
                    <a href="{{ route('books.index') }}" style="background: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">Cari Buku Sekarang</a>
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead style="background: #f1f5f9; color: #475569; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th style="padding: 14px 20px;">Judul Buku</th>
                            <th style="padding: 14px 20px;">Tanggal Pinjam</th>
                            <th style="padding: 14px 20px;">Batas Kembali</th>
                            <th style="padding: 14px 20px;">Status</th>
                            <th style="padding: 14px 20px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 16px 20px;">
                                    <strong style="color: #0f172a; display: block;">{{ $loan->title }}</strong>
                                    <span style="color: #64748b; font-size: 12px;">{{ $loan->author }}</span>
                                </td>
                                <td style="padding: 16px 20px;">{{ $loan->loan_date }}</td>
                                <td style="padding: 16px 20px; font-weight: 600; color: #dc2626;">{{ $loan->due_date }}</td>
                                <td style="padding: 16px 20px;">
                                    @if($loan->status === 'borrowed')
                                        <span style="background: #fef3c7; color: #b45309; padding: 4px 10px; border-radius: 99px; font-size: 12px; font-weight: 600;">Sedang Dipinjam</span>
                                    @else
                                        <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 99px; font-size: 12px; font-weight: 600;">Sudah Dikembalikan</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 20px;">
                                    @if($loan->status === 'borrowed')
                                        <form action="{{ route('books.return', $loan->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Kembalikan buku {{ $loan->title }} sekarang?')" style="background: #0f172a; color: white; border: none; padding: 7px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                Kembalikan Buku
                                            </button>
                                        </form>
                                    @else
                                        <span style="color: #94a3b8; font-size: 12px;">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>

</body>
</html>