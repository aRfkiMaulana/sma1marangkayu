<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi SMA Negeri 1 Marangkayu - Kutai Kartanegara, Kalimantan Timur">
    <title>@yield('title', 'SMA Negeri 1 Marangkayu')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animate -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary:   #1a3d6e;
            --secondary: #e8a020;
            --accent:    #c0392b;
            --light-bg:  #f4f7fc;
        }
        body { font-family: 'Poppins', sans-serif; color: #333; }

        /* NAVBAR */
        .navbar-main { background: var(--primary); box-shadow: 0 2px 10px rgba(0,0,0,.2); }
        .navbar-main .navbar-brand { font-weight: 700; font-size: 1.1rem; }
        .navbar-main .navbar-brand img { display: block; width: 46px; height: 46px; object-fit: contain; background: transparent; border-radius: 0; padding: 0; }
        .navbar-main .brand-text { line-height: 1.1; }
        .navbar-main .brand-text small { display: block; font-size: .72rem; opacity: .85; }
        .navbar-main .brand-text strong { display: block; font-size: 1.2rem; letter-spacing: .02em; }
        .navbar-main .nav-link { color: rgba(255,255,255,.85) !important; font-weight: 500; transition: .2s; }
        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active { color: var(--secondary) !important; }
        .navbar-main .dropdown-menu { border: none; box-shadow: 0 4px 20px rgba(0,0,0,.15); }

        /* TOP BAR */
        .topbar { background: #0d2a4f; font-size: .82rem; color: rgba(255,255,255,.7); padding: 6px 0; }
        .topbar a { color: rgba(255,255,255,.7); text-decoration: none; }
        .topbar a:hover { color: var(--secondary); }

        /* HERO / SLIDER */
        .hero-slider .carousel-item { height: 520px; }
        .hero-slider .carousel-item img { object-fit: cover; height: 100%; width: 100%; filter: brightness(.65); }
        .hero-slider .carousel-caption h2 { font-size: 2.4rem; font-weight: 700; text-shadow: 1px 1px 6px rgba(0,0,0,.5); }
        .hero-slider .carousel-caption p  { font-size: 1.1rem; }

        /* SECTION */
        .section-title { font-weight: 700; color: var(--primary); position: relative; display: inline-block; }
        .section-title::after { content: ''; display: block; width: 50px; height: 3px; background: var(--secondary); margin-top: 6px; }

        /* CARDS */
        .card-berita { border: none; box-shadow: 0 2px 12px rgba(0,0,0,.08); transition: .25s; }
        .card-berita:hover { transform: translateY(-4px); box-shadow: 0 6px 24px rgba(0,0,0,.14); }
        .card-berita .card-img-top { height: 190px; object-fit: cover; }
        .badge-tipe { font-size: .72rem; text-transform: uppercase; letter-spacing: .05em; }

        /* STAT BOX */
        .stat-box { background: var(--primary); color: #fff; border-radius: 12px; padding: 24px; text-align: center; }
        .stat-box .stat-num { font-size: 2.4rem; font-weight: 700; color: var(--secondary); }

        /* GALERI */
        .galeri-item { overflow: hidden; border-radius: 8px; cursor: pointer; }
        .galeri-item img { transition: .3s; height: 200px; object-fit: cover; width: 100%; }
        .galeri-item:hover img { transform: scale(1.06); }

        /* FOOTER */
        footer { background: var(--primary); color: rgba(255,255,255,.8); }
        footer h6 { color: var(--secondary); font-weight: 600; text-transform: uppercase; font-size: .85rem; letter-spacing: .06em; }
        footer a { color: rgba(255,255,255,.7); text-decoration: none; transition: .2s; }
        footer a:hover { color: var(--secondary); }
        .footer-bottom { background: #0d2a4f; font-size: .82rem; }

        /* BREADCRUMB */
        .breadcrumb-section { background: var(--light-bg); border-bottom: 1px solid #e0e7f0; }

        /* UTIL */
        .btn-primary-custom { background: var(--primary); border: none; color: #fff; }
        .btn-primary-custom:hover { background: #152f56; color: #fff; }
        .btn-secondary-custom { background: var(--secondary); border: none; color: #fff; }
        .btn-secondary-custom:hover { background: #c9880f; color: #fff; }
        .text-primary-custom { color: var(--primary) !important; }
        .text-secondary-custom { color: var(--secondary) !important; }
        .bg-primary-custom { background: var(--primary) !important; }
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-main sticky-top" style="height: 75px">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-white" href="{{ route('home') }}">
            <img src="{{ asset('images/logo sma.jpg') }}" alt="Logo SMA Negeri 1 Marangkayu" width="46" height="46">
            <div class="brand-text lh-sm">
                <small>SMA Negeri</small>
                <strong>1 Marangkayu</strong>
            </div>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Toggle navigation">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('profil.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">Profil</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profil.sejarah') }}">Sejarah Sekolah</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.visi-misi') }}">Visi &amp; Misi</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.struktur-organisasi') }}">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item" href="{{ route('profil.fasilitas') }}">Fasilitas</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('akademik.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">Akademik</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('akademik.kurikulum') }}">Kurikulum</a></li>
                        <li><a class="dropdown-item" href="{{ route('akademik.program-studi') }}">Program Studi</a></li>
                        <li><a class="dropdown-item" href="{{ route('akademik.ekstrakurikuler') }}">Ekstrakurikuler</a></li>
                        <li><a class="dropdown-item" href="{{ route('akademik.kalender') }}">Kalender Akademik</a></li>
                        <li><a class="dropdown-item" href="{{ route('akademik.prestasi') }}">Prestasi</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}" href="{{ route('berita.index') }}">Berita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('galeri.*') ? 'active' : '' }}" href="{{ route('galeri.index') }}">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h6>SMA Negeri 1 Marangkayu</h6>
                <p class="small mt-2">
                    Jl. Poros Samarinda - Bontang, Marangkayu<br>
                    Kutai Kartanegara, Kalimantan Timur
                </p>
                <p class="small">
                    <i class="bi bi-telephone me-1"></i> (0541) 000000<br>
                    <i class="bi bi-envelope me-1"></i> sman1marangkayu@gmail.com
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-sm" style="background:rgba(255,255,255,.1);color:#fff;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-sm" style="background:rgba(255,255,255,.1);color:#fff;"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-sm" style="background:rgba(255,255,255,.1);color:#fff;"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6>Profil</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('profil.sejarah') }}">Sejarah</a></li>
                    <li><a href="{{ route('profil.visi-misi') }}">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('profil.struktur-organisasi') }}">Struktur Org.</a></li>
                    <li><a href="{{ route('profil.fasilitas') }}">Fasilitas</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6>Akademik</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('akademik.kurikulum') }}">Kurikulum</a></li>
                    <li><a href="{{ route('akademik.ekstrakurikuler') }}">Ekstrakurikuler</a></li>
                    <li><a href="{{ route('akademik.prestasi') }}">Prestasi</a></li>
                    <li><a href="{{ route('akademik.kalender') }}">Kalender</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6>Informasi</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('berita.index') }}">Berita</a></li>
                    <li><a href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li><a href="{{ route('kontak') }}">Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6>Tautan</h6>
                <ul class="list-unstyled small">
                    <li><a href="https://kemdikbud.go.id" target="_blank">Kemdikbud</a></li>
                    <li><a href="https://disdik.kukarkab.go.id" target="_blank">Disdik KuKar</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom mt-4 py-3 text-center">
        <div class="container">
            <small>&copy; {{ date('Y') }} SMA Negeri 1 Marangkayu. Hak Cipta Dilindungi.</small>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ once: true, duration: 700 });</script>
@stack('scripts')
</body>
</html>
