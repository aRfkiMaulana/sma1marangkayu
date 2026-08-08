<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin SMAN 1 Marangkayu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-slate-100 font-sans" x-data="{ sidebarOpen: false }">

<div class="flex h-full">

    {{-- SIDEBAR OVERLAY (mobile) --}}
    <div x-show="sidebarOpen" @click="sidebarOpen=false"
         class="fixed inset-0 bg-black/40 z-20 lg:hidden" style="display:none"></div>

    {{-- SIDEBAR --}}
    <aside class="fixed top-0 left-0 h-full w-64 z-30 flex flex-col transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           style="background-color: var(--color-primary)">

        {{-- Brand --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-base"
                 style="background-color: var(--color-accent)">
                <i class="fa-solid fa-graduation-cap text-white"></i>
            </div>
            <div class="leading-tight">
                <p class="text-xs text-white/60">Admin Panel</p>
                <p class="text-sm font-bold text-white">SMAN 1 Marangkayu</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-0.5">

            <p class="px-3 pt-2 pb-1 text-xs font-semibold uppercase tracking-widest text-white/35">Utama</p>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-widest text-white/35">Konten</p>
            <a href="{{ route('admin.slider.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.slider.*') ? 'active' : '' }}">
                <i class="fa-solid fa-images w-5 text-center"></i> Slider / Banner
            </a>
            <a href="{{ route('admin.berita.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper w-5 text-center"></i> Berita
            </a>
            <a href="{{ route('admin.galeri.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <i class="fa-solid fa-image w-5 text-center"></i> Galeri
            </a>
            <a href="{{ route('admin.fasilitas.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building w-5 text-center"></i> Fasilitas
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-widest text-white/35">Data Sekolah</p>
            <a href="{{ route('admin.profil.edit') }}"
               class="sidebar-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                <i class="fa-solid fa-school w-5 text-center"></i> Profil Sekolah
            </a>
            <a href="{{ route('admin.guru-staf.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.guru-staf.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user w-5 text-center"></i> Guru &amp; Staf
            </a>
            <a href="{{ route('admin.pesan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope w-5 text-center"></i> Pesan Masuk
                @php $unread = \App\Models\Pesan::where('is_read', false)->count(); @endphp
                @if($unread > 0)
                <span class="ml-auto text-xs font-bold bg-red-500 text-white px-1.5 py-0.5 rounded-full">{{ $unread }}</span>
                @endif
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-widest text-white/35">Buku Tahunan</p>
            <a href="{{ route('admin.angkatan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.angkatan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap w-5 text-center"></i> Kelola Angkatan
            </a>
            <a href="{{ route('admin.siswa.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <i class="fa-solid fa-address-card w-5 text-center"></i> Data Siswa & Approval
                @php $pendingSiswa = \App\Models\Siswa::where('status', 'pending')->count(); @endphp
                @if($pendingSiswa > 0)
                <span class="ml-auto text-xs font-bold bg-amber-500 text-white px-1.5 py-0.5 rounded-full">{{ $pendingSiswa }}</span>
                @endif
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-widest text-white/35">Akademik</p>
            <a href="{{ route('admin.kurikulum.edit') }}"
               class="sidebar-link {{ request()->routeIs('admin.kurikulum.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open w-5 text-center"></i> Kurikulum
            </a>
            <a href="{{ route('admin.kalender.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.kalender.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days w-5 text-center"></i> Kalender Akademik
            </a>
            <a href="{{ route('admin.ekstrakurikuler.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.ekstrakurikuler.*') ? 'active' : '' }}">
                <i class="fa-solid fa-star w-5 text-center"></i> Ekstrakurikuler
            </a>
            <a href="{{ route('admin.prestasi.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                <i class="fa-solid fa-trophy w-5 text-center"></i> Prestasi
            </a>

            <p class="px-3 pt-4 pb-1 text-xs font-semibold uppercase tracking-widest text-white/35">Pengaturan</p>
            <a href="{{ route('admin.setting-bobot.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.setting-bobot.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders w-5 text-center"></i> Bobot Poin Prestasi
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear w-5 text-center"></i> Pengelola CMS
            </a>
            <a href="{{ route('admin.logs.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i> Log Aktivitas
            </a>
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i> Lihat Website
            </a>
        </nav>

        {{-- User + Logout --}}
        <div class="border-t border-white/10 px-3 py-4">
            <div class="flex items-center gap-3 px-2 mb-2">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=e8a020&color=fff&size=36"
                     class="w-9 h-9 rounded-xl object-cover flex-shrink-0" alt="">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-white/50 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0 lg:ml-0">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen=!sidebarOpen"
                        class="lg:hidden text-gray-500 hover:text-gray-800 p-1">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h1 class="font-semibold text-gray-800 text-sm md:text-base">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.pesan.index') }}" class="relative text-gray-500 hover:text-gray-800 p-1.5">
                    <i class="fa-regular fa-bell text-lg"></i>
                    @if($unread > 0)
                    <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">{{ $unread }}</span>
                    @endif
                </a>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-6 overflow-y-auto">
            {{-- ALERTS --}}
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 mb-5">
                <i class="fa-solid fa-circle-check text-green-500"></i>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 mb-5">
                <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
