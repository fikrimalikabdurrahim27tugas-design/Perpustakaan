<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku — LIBRA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: #f8fafc; font-family: sans-serif; margin: 0; color: #1e293b;">

    <!-- NAVBAR -->
    <header style="background: white; border-bottom: 1px solid #e2e8f0; padding: 16px 0; position: sticky; top: 0; z-index: 10;">
        <div style="max-width: 1140px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('home') }}" style="text-decoration: none; font-weight: 800; font-size: 22px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <span style="background: #2563eb; color: white; padding: 2px 10px; border-radius: 6px;">L</span>
                <span>LIBRA<span style="color: #2563eb;">.</span></span>
            </a>

            <div style="display: flex; align-items: center; gap: 18px;">
                <a href="{{ route('home') }}" style="text-decoration: none; color: #475569; font-weight: 600; font-size: 14px;">Beranda</a>
                <a href="{{ route('books.index') }}" style="text-decoration: none; color: #2563eb; font-weight: 700; font-size: 14px;">Katalog Buku</a>
                <a href="{{ route('loans.index') }}" style="text-decoration: none; color: #475569; font-weight: 600; font-size: 14px;">Pinjaman Saya</a>

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

    <main style="max-width: 1140px; margin: 40px auto; padding: 0 20px;">
        
        <!-- Header & Pencarian -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 30px;">
            <div>
                <h1 style="margin: 0; font-size: 28px; color: #0f172a;">
                    Koleksi Buku {{ $category ? '— ' . ucfirst($category) : '' }}
                </h1>
                <p style="margin: 6px 0 0; color: #64748b; font-size: 14px;">Maksimal peminjaman 3 buku aktif dengan durasi 7 hari.</p>
            </div>

            <form action="{{ route('books.index') }}" method="GET" style="display: flex; gap: 8px;">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul atau penulis..." style="padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; width: 250px; font-size: 14px;">
                <button type="submit" style="background: #2563eb; color: white; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer;">Cari</button>
            </form>
        </div>

        <!-- Filter Kategori -->
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px;">
            <a href="{{ route('books.index') }}" style="padding: 8px 16px; border-radius: 99px; text-decoration: none; font-size: 13px; font-weight: 600; {{ !$category ? 'background: #2563eb; color: white;' : 'background: white; color: #475569; border: 1px solid #e2e8f0;' }}">Semua</a>
            @foreach(['technology', 'science', 'business', 'literature', 'finance', 'self-development'] as $cat)
                <a href="{{ route('books.index', ['category' => $cat]) }}" style="padding: 8px 16px; border-radius: 99px; text-decoration: none; font-size: 13px; font-weight: 600; {{ $category == $cat ? 'background: #2563eb; color: white;' : 'background: white; color: #475569; border: 1px solid #e2e8f0;' }}">
                    {{ ucfirst(str_replace('-', ' ', $cat)) }}
                </a>
            @endforeach
        </div>

        <!-- Alert Error / Sukses -->
        @if (session('error'))
            <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 14px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- Grid Buku -->
        @if($books->isEmpty())
            <div style="background: white; padding: 50px; text-align: center; border-radius: 12px; border: 1px solid #e2e8f0;">
                <p style="color: #64748b; font-size: 16px; margin: 0;">Belum ada buku yang sesuai dengan pencarian Anda.</p>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px;">
                @foreach($books as $book)
                    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <span style="background: #eff6ff; color: #2563eb; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                                    {{ $book->category }}
                                </span>
                                <span style="font-size: 12px; font-weight: 600; color: {{ $book->stock > 0 ? '#16a34a' : '#dc2626' }};">
                                    Stok: {{ $book->stock }}
                                </span>
                            </div>

                            <h3 style="margin: 0 0 6px; font-size: 18px; color: #0f172a;">{{ $book->title }}</h3>
                            <p style="margin: 0 0 12px; font-size: 13px; color: #64748b; font-weight: 600;">Oleh {{ $book->author }}</p>
                            <p style="margin: 0 0 20px; font-size: 13px; color: #475569; line-height: 1.5;">{{ $book->description }}</p>
                        </div>

                        <form action="{{ route('books.borrow', $book->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            @if($book->stock > 0)
                                <button type="submit" onclick="return confirm('Pinjam buku {{ $book->title }} selama 7 hari?')" style="width: 100%; background: #2563eb; color: white; border: none; padding: 11px; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                                    Pinjam Buku
                                </button>
                            @else
                                <button type="button" disabled style="width: 100%; background: #e2e8f0; color: #94a3b8; border: none; padding: 11px; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: not-allowed;">
                                    Stok Habis
                                </button>
                            @endif
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

    </main>
</body>
</html>