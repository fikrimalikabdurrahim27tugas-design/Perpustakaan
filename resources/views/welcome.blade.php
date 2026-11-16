<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LIBRA - Universal Gateway to Books & Learning. Temukan dunia pengetahuan melalui perpustakaan digital.">
    <title>LIBRA — Universal Gateway to Books & Learning</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="container nav-wrapper">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-icon">L</span>
                <span>LIBRA<span class="brand-dot">.</span></span>
            </a>

            <button class="menu-toggle" id="menuToggle" aria-label="Buka menu">
                ☰
            </button>

            <nav class="nav-menu" id="navMenu">
                <a href="#home" class="active">Home</a>
                <a href="#categories">Categories</a>
                <a href="#books">Explore Books</a>
                <a href="#about">About Us</a>
                @auth
                    <a href="{{ route('loans.index') }}" style="color: #2563eb; font-weight: 600;">Pinjaman Saya</a>
                @endauth
            </nav>

            <div class="nav-actions" style="display: flex; align-items: center; gap: 14px;">
                @guest
                    <a href="{{ route('login') }}" class="login-link">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary nav-register">
                        Get Started <span>↗</span>
                    </a>
                @endguest

                @auth
                    <!-- Badge Profil Siswa yang Sedang Login -->
                    <div style="display: flex; align-items: center; gap: 8px; background: #eff6ff; padding: 6px 14px; border-radius: 99px; border: 1px solid #bfdbfe;">
                        <span style="width: 26px; height: 26px; background: #2563eb; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <span style="font-weight: 600; color: #1e3a8a; font-size: 14px;">
                            {{ Auth::user()->name }}
                        </span>
                    </div>

                    <!-- Tombol Logout -->
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 8px 14px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <main>

        <!-- HERO SECTION -->
        <section class="hero" id="home">
            <div class="container hero-grid">

                <div class="hero-content">
                    <div class="eyebrow">
                        <span class="eyebrow-dot"></span>
                        YOUR DIGITAL LIBRARY EXPERIENCE
                    </div>

                    <h1>
                        Discover a World
                        of <span>Knowledge.</span>
                    </h1>

                    <p class="hero-description">
                        Explore endless possibilities through books.
                        Find inspiration, gain knowledge, and unlock
                        your potential with LIBRA.
                    </p>

                    <form class="search-box" id="searchForm">
                        <span class="search-icon">⌕</span>
                        <input
                            type="search"
                            id="bookSearch"
                            placeholder="Search books, authors, or topics..."
                            aria-label="Cari buku"
                        >
                        <button type="submit">Search</button>
                    </form>

                    <div class="hero-note">
                        <span class="note-check">✓</span>
                        Your gateway to unlimited knowledge
                    </div>

                    <div class="hero-stats">
                        <div>
                            <h3>1,200<span>+</span></h3>
                            <p>Books Available</p>
                        </div>
                        <div>
                            <h3>850<span>+</span></h3>
                            <p>Active Readers</p>
                        </div>
                        <div>
                            <h3>50<span>+</span></h3>
                            <p>Book Categories</p>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-circle"></div>
                    <div class="visual-label">READ. LEARN. GROW.</div>

                    <div class="book-stack">
                        <div class="book book-one">
                            <div class="book-decoration">✦</div>
                            <span>THE ART OF</span>
                            <strong>CREATIVE<br>THINKING</strong>
                            <small>IDEAS THAT CHANGE THE WORLD</small>
                        </div>

                        <div class="book book-two">
                            <span>THE POWER OF</span>
                            <strong>KNOWLEDGE</strong>
                            <div class="book-line"></div>
                            <small>EXPLORE YOUR POTENTIAL</small>
                        </div>

                        <div class="book book-three">
                            <span>EXPLORE</span>
                            <strong>THE<br>UNIVERSE</strong>
                            <small>SCIENCE & DISCOVERY</small>
                        </div>
                    </div>

                    <div class="floating-card card-top">
                        <span class="floating-icon">✧</span>
                        <div>
                            <strong>Explore More</strong>
                            <small>Knowledge awaits you</small>
                        </div>
                    </div>

                    <div class="floating-card card-bottom">
                        <span class="floating-icon">↗</span>
                        <div>
                            <strong>Keep Learning</strong>
                            <small>Grow every single day</small>
                        </div>
                    </div>

                    <div class="visual-orbit orbit-one"></div>
                    <div class="visual-orbit orbit-two"></div>
                </div>

            </div>
        </section>

        <!-- TRUST BAR -->
        <section class="trust-section">
            <div class="container trust-content">
                <p>A BETTER WAY TO DISCOVER KNOWLEDGE</p>
                <div class="trust-features">
                    <span>✦ Easy Book Discovery</span>
                    <span>✦ Diverse Collections</span>
                    <span>✦ Learn Without Limits</span>
                </div>
            </div>
        </section>

        <!-- CATEGORIES -->
        <section class="section categories-section" id="categories">
            <div class="container">

                <div class="section-heading">
                    <div>
                        <span class="section-label">EXPLORE YOUR INTEREST</span>
                        <h2>Explore by <span>Categories.</span></h2>
                        <p>Discover books from various fields of knowledge.</p>
                    </div>

                    <a href="{{ route('books.index') }}" class="text-link">
                        View All Categories →
                    </a>
                </div>

                <div class="category-grid">

                    <a href="{{ route('books.index', ['category' => 'technology']) }}" class="category-card">
                        <div class="category-icon icon-blue">⌘</div>
                        <h3>Technology</h3>
                        <p>Innovation & Digital World</p>
                        <span class="category-arrow">↗</span>
                    </a>

                    <a href="{{ route('books.index', ['category' => 'science']) }}" class="category-card">
                        <div class="category-icon icon-purple">⚛</div>
                        <h3>Science</h3>
                        <p>Explore the Universe</p>
                        <span class="category-arrow">↗</span>
                    </a>

                    <a href="{{ route('books.index', ['category' => 'business']) }}" class="category-card">
                        <div class="category-icon icon-orange">▤</div>
                        <h3>Business</h3>
                        <p>Ideas & Entrepreneurship</p>
                        <span class="category-arrow">↗</span>
                    </a>

                    <a href="{{ route('books.index', ['category' => 'literature']) }}" class="category-card">
                        <div class="category-icon icon-green">✎</div>
                        <h3>Literature</h3>
                        <p>Stories & Imagination</p>
                        <span class="category-arrow">↗</span>
                    </a>

                </div>
            </div>
        </section>

        <!-- POPULAR BOOKS -->
        <section class="section books-section" id="books">
            <div class="container">

                <div class="section-heading">
                    <div>
                        <span class="section-label">HANDPICKED FOR YOU</span>