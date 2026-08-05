<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website Resmi SMA Negeri 1 Marangkayu - Kutai Kartanegara, Kalimantan Timur">
    <title>@yield('title', 'SMA Negeri 1 Marangkayu')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased">

{{-- TOP BAR --}}
<div class="hidden md:block text-xs py-2" style="background-color: var(--color-primary-dark); color: rgba(255,255,255,0.7)">
    <div class="container mx-auto max-w-7xl px-4 flex justify-between items-center">
        <span><i class="fa-solid fa-location-dot mr-1"></i> Marangkayu, Kutai Kartanegara, Kalimantan Timur</span>
        <div class="flex gap-4">
            <a href="#" class="hover:text-yellow-400 transition-colors"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="hover:text-yellow-400 transition-colors"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="hover:text-yellow-400 transition-colors"><i class="fa-brands fa-youtube"></i></a>
        </div>
    </div>
</div>

{{-- NAVBAR --}}
<nav class="sticky top-0 z-50 shadow-md" style="background-color: var(--color-primary)" x-data="{ open: false }">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="flex items-center justify-between h-16">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-white">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain"
                     onerror="this.style.display='none'">
                <div class="leading-tight">
                    <div class="text-xs opacity-80">SMA Negeri</div>
                    <div class="font-bold text-base">1 Marangkayu</div>
                </div>
            </a>

            {{-- DESKTOP NAV --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-yellow-400' : 'text-white/85 hover:text-yellow-400' }}">
                    Beranda
                </a>

                {{-- Profil Dropdown --}}
                <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('profil.*') ? 'text-yellow-400' : 'text-white/85 hover:text-yellow-400' }}">
                        Profil <i class="fa-solid fa-chevron-down text-xs mt-0.5"></i>
                    </button>
                    <div x-show="open" x-transition
                         class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-xl py-2 z-50">
                        <a href="{{ route('profil.sejarah') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Sejarah Sekolah</a>
                        <a href="{{ route('profil.visi-misi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Visi &amp; Misi</a>
                        <a href="{{ route('profil.struktur-organisasi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Guru &amp; Staf</a>
                        <a href="{{ route('profil.fasilitas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Fasilitas</a>
                    </div>
                </div>

                {{-- Akademik Dropdown --}}
                <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('akademik.*') ? 'text-yellow-400' : 'text-white/85 hover:text-yellow-400' }}">
                        Akademik <i class="fa-solid fa-chevron-down text-xs mt-0.5"></i>
                    </button>
                    <div x-show="open" x-transition
                         class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-xl py-2 z-50">
                        <a href="{{ route('akademik.kurikulum') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Kurikulum</a>
                        <a href="{{ route('akademik.program-studi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Program Studi</a>
                        <a href="{{ route('akademik.ekstrakurikuler') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Ekstrakurikuler</a>
                        <a href="{{ route('akademik.kalender') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Kalender Akademik</a>
                        <a href="{{ route('akademik.prestasi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800">Prestasi</a>
                    </div>
                </div>

                <a href="{{ route('berita.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('berita.*') ? 'text-yellow-400' : 'text-white/85 hover:text-yellow-400' }}">
                    Berita
                </a>
                <a href="{{ route('galeri.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('galeri.*') ? 'text-yellow-400' : 'text-white/85 hover:text-yellow-400' }}">
                    Galeri
                </a>
                <a href="{{ route('kontak') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('kontak') ? 'text-yellow-400' : 'text-white/85 hover:text-yellow-400' }}">
                    Kontak
                </a>
                @auth
                <a href="{{ route('admin.dashboard') }}"
                   class="ml-2 px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors"
                   style="background-color: var(--color-accent)">
                    <i class="fa-solid fa-gauge-high mr-1"></i> Admin
                </a>
                @endauth
            </div>

            {{-- MOBILE TOGGLE --}}
            <button @click="open=!open" class="lg:hidden text-white p-2">
                <i class="fa-solid fa-bars text-xl" x-show="!open"></i>
                <i class="fa-solid fa-xmark text-xl" x-show="open" style="display:none"></i>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-show="open" x-transition class="lg:hidden border-t border-white/10 pb-4">
        <div class="container mx-auto max-w-7xl px-4 pt-3 flex flex-col gap-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10">Beranda</a>
            <div class="px-3 py-1 text-xs text-white/40 uppercase tracking-widest mt-1">Profil</div>
            <a href="{{ route('profil.sejarah') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10 pl-5">Sejarah Sekolah</a>
            <a href="{{ route('profil.visi-misi') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10 pl-5">Visi &amp; Misi</a>
            <a href="{{ route('profil.struktur-organisasi') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10 pl-5">Guru &amp; Staf</a>
            <a href="{{ route('profil.fasilitas') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10 pl-5">Fasilitas</a>
            <div class="px-3 py-1 text-xs text-white/40 uppercase tracking-widest mt-1">Akademik</div>
            <a href="{{ route('akademik.kurikulum') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10 pl-5">Kurikulum</a>
            <a href="{{ route('akademik.ekstrakurikuler') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10 pl-5">Ekstrakurikuler</a>
            <a href="{{ route('akademik.prestasi') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10 pl-5">Prestasi</a>
            <a href="{{ route('berita.index') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10">Berita</a>
            <a href="{{ route('galeri.index') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10">Galeri</a>
            <a href="{{ route('kontak') }}" class="block px-3 py-2 text-white/85 text-sm rounded-lg hover:bg-white/10">Kontak</a>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="pt-14 pb-4 mt-16" style="background-color: var(--color-primary)">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
            <div>
                <h6 class="text-sm font-bold uppercase tracking-widest mb-4" style="color: var(--color-accent)">
                    SMA Negeri 1 Marangkayu
                </h6>
                <p class="text-white/65 text-sm leading-relaxed mb-4">
                    Jl. Poros Samarinda - Bontang, Marangkayu<br>
                    Kutai Kartanegara, Kalimantan Timur
                </p>
                <p class="text-white/65 text-sm mb-1"><i class="fa-solid fa-phone mr-2 text-yellow-400"></i>(0541) 000000</p>
                <p class="text-white/65 text-sm"><i class="fa-solid fa-envelope mr-2 text-yellow-400"></i>sman1marangkayu@gmail.com</p>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/70 hover:bg-yellow-400 hover:text-white transition-colors text-sm">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/70 hover:bg-yellow-400 hover:text-white transition-colors text-sm">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/70 hover:bg-yellow-400 hover:text-white transition-colors text-sm">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
            <div>
                <h6 class="text-sm font-bold uppercase tracking-widest mb-4" style="color: var(--color-accent)">Profil</h6>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('profil.sejarah') }}" class="text-white/65 hover:text-yellow-400">Sejarah</a></li>
                    <li><a href="{{ route('profil.visi-misi') }}" class="text-white/65 hover:text-yellow-400">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('profil.struktur-organisasi') }}" class="text-white/65 hover:text-yellow-400">Guru &amp; Staf</a></li>
                    <li><a href="{{ route('profil.fasilitas') }}" class="text-white/65 hover:text-yellow-400">Fasilitas</a></li>
                </ul>
            </div>
            <div>
                <h6 class="text-sm font-bold uppercase tracking-widest mb-4" style="color: var(--color-accent)">Akademik</h6>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('akademik.kurikulum') }}" class="text-white/65 hover:text-yellow-400">Kurikulum</a></li>
                    <li><a href="{{ route('akademik.ekstrakurikuler') }}" class="text-white/65 hover:text-yellow-400">Ekstrakurikuler</a></li>
                    <li><a href="{{ route('akademik.prestasi') }}" class="text-white/65 hover:text-yellow-400">Prestasi</a></li>
                    <li><a href="{{ route('akademik.kalender') }}" class="text-white/65 hover:text-yellow-400">Kalender</a></li>
                </ul>
            </div>
            <div>
                <h6 class="text-sm font-bold uppercase tracking-widest mb-4" style="color: var(--color-accent)">Informasi</h6>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('berita.index') }}" class="text-white/65 hover:text-yellow-400">Berita</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="text-white/65 hover:text-yellow-400">Galeri</a></li>
                    <li><a href="{{ route('kontak') }}" class="text-white/65 hover:text-yellow-400">Kontak</a></li>
                    <li><a href="https://kemdikbud.go.id" target="_blank" class="text-white/65 hover:text-yellow-400">Kemdikbud</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pt-4 text-center text-white/40 text-xs">
            &copy; {{ date('Y') }} SMA Negeri 1 Marangkayu. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
