<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - SMA Negeri 1 Marangkayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-w: 250px; --primary: #1a3d6e; --secondary: #e8a020; }
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; }

        /* SIDEBAR */
        #sidebar {
            width: var(--sidebar-w); min-height: 100vh; background: var(--primary);
            position: fixed; top: 0; left: 0; z-index: 1000; transition: .3s;
            overflow-y: auto;
        }
        #sidebar .brand { padding: 20px 16px; border-bottom: 1px solid rgba(255,255,255,.1); }
        #sidebar .brand span { font-size: .95rem; font-weight: 600; color: #fff; }
        #sidebar .nav-link { color: rgba(255,255,255,.75); padding: 9px 16px; border-radius: 6px; margin: 2px 8px; font-size: .88rem; transition: .2s; }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active { background: rgba(255,255,255,.12); color: var(--secondary); }
        #sidebar .nav-section { color: rgba(255,255,255,.4); font-size: .7rem; text-transform: uppercase; letter-spacing: .1em; padding: 12px 16px 4px; }

        /* MAIN */
        #main { margin-left: var(--sidebar-w); min-height: 100vh; transition: .3s; }
        .topbar-admin { background: #fff; padding: 12px 24px; box-shadow: 0 1px 4px rgba(0,0,0,.08); display: flex; align-items: center; justify-content: space-between; }

        .stat-card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 1px 8px rgba(0,0,0,.07); }
        .stat-card .icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }

        @media(max-width: 768px) {
            #sidebar { left: -var(--sidebar-w); }
            #sidebar.show { left: 0; }
            #main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<div id="sidebar">
    <div class="brand d-flex align-items-center gap-2">
        <i class="bi bi-mortarboard-fill text-warning fs-4"></i>
        <span>SMAN 1 Marangkayu</span>
    </div>

    <div class="mt-2">
        <div class="nav-section">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Konten</div>
        <a href="{{ route('admin.slider.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.slider.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Slider / Banner
        </a>
        <a href="{{ route('admin.berita.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Berita &amp; Pengumuman
        </a>
        <a href="{{ route('admin.galeri.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
            <i class="bi bi-image"></i> Galeri
        </a>
        <a href="{{ route('admin.fasilitas.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Fasilitas
        </a>

        <div class="nav-section">Data Sekolah</div>
        <a href="{{ route('admin.guru-staf.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.guru-staf.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Guru &amp; Staf
        </a>
        <a href="{{ route('admin.pesan.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Pesan Masuk
            @php $unread = \App\Models\Pesan::where('is_read', false)->count(); @endphp
            @if($unread > 0)<span class="badge bg-danger ms-auto">{{ $unread }}</span>@endif
        </a>

        <div class="nav-section">Pengaturan</div>
        <a href="{{ route('admin.profil.edit') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Profil Sekolah
        </a>
        <a href="{{ route('home') }}" class="nav-link d-flex align-items-center gap-2" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i> Lihat Website
        </a>

        <div class="nav-section">Akun</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start d-flex align-items-center gap-2">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>

{{-- MAIN --}}
<div id="main">
    {{-- TOPBAR --}}
    <div class="topbar-admin">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h6 class="mb-0 fw-600">@yield('title', 'Dashboard')</h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="small text-muted">{{ auth()->user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1a3d6e&color=fff&size=36"
                 class="rounded-circle" width="36" height="36" alt="Avatar">
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="p-4">
        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
