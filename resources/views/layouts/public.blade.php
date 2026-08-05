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

{{-- NAVBAR --}}
<nav class="shadow-sm border-b border-gray-100 sticky top-0 z-50 bg-white">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-4">
        <div class="flex items-center justify-between h-20">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo SMA Negeri 1 Marangkayu"
                     class="w-12 h-auto object-contain flex-shrink-0" style="max-height:56px"
                     onerror="this.style.display='none'">
                <div class="leading-tight">
                    <div class="text-lg sm:text-xl font-bold text-gray-800 leading-tight">SMA Negeri 1</div>
                    <div class="text-sm text-gray-500 leading-snug">Marangkayu</div>
                </div>
            </a>

            {{-- DESKTOP NAV --}}
            <div class="hidden lg:flex items-center gap-1 text-lg lg:text-xl font-semibold">

                <a href="{{ route('home') }}"
                   class="px-3 py-2 rounded-md transition-colors {{ request()->routeIs('home') ? '' : 'text-gray-600 hover:text-gray-900' }}"
                   style="{{ request()->routeIs('home') ? 'color:var(--color-primary)' : '' }}">
                    Beranda
                </a>

                {{-- Profil Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open"
                            class="flex items-center gap-1 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('profil.*') ? '' : 'text-gray-600 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('profil.*') ? 'color:var(--color-primary)' : '' }}">
                        Profil
                        <svg class="w-3 h-3 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute top-full left-0 mt-1 w-56 bg-white rounded-xl border border-gray-100 shadow-lg py-1 z-50"
                         @click="open = false" style="display:none">
                        <a href="{{ route('profil.sejarah') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Sejarah Sekolah</a>
                        <a href="{{ route('profil.visi-misi') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Visi &amp; Misi</a>
                        <a href="{{ route('profil.struktur-organisasi') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Guru &amp; Staf</a>
                        <a href="{{ route('profil.fasilitas') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Fasilitas</a>
                    </div>
                </div>

                {{-- Akademik Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open"
                            class="flex items-center gap-1 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('akademik.*') ? '' : 'text-gray-600 hover:text-gray-900' }}"
                            style="{{ request()->routeIs('akademik.*') ? 'color:var(--color-primary)' : '' }}">
                        Akademik
                        <svg class="w-3 h-3 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute top-full left-0 mt-1 w-56 bg-white rounded-xl border border-gray-100 shadow-lg py-1 z-50"
                         @click="open = false" style="display:none">
                        <a href="{{ route('akademik.kurikulum') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Kurikulum</a>
                        <a href="{{ route('akademik.program-studi') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Program Studi</a>
                        <a href="{{ route('akademik.ekstrakurikuler') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Ekstrakurikuler</a>
                        <a href="{{ route('akademik.kalender') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Kalender Akademik</a>
                        <a href="{{ route('akademik.prestasi') }}" class="block px-4 py-2.5 text-sm text-gray-600 font-medium" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Prestasi</a>
                    </div>
                </div>

                <a href="{{ route('berita.index') }}"
                   class="px-3 py-2 rounded-md transition-colors {{ request()->routeIs('berita.*') ? '' : 'text-gray-600 hover:text-gray-900' }}"
                   style="{{ request()->routeIs('berita.*') ? 'color:var(--color-primary)' : '' }}">
                    Berita
                </a>
                <a href="{{ route('galeri.index') }}"
                   class="px-3 py-2 rounded-md transition-colors {{ request()->routeIs('galeri.*') ? '' : 'text-gray-600 hover:text-gray-900' }}"
                   style="{{ request()->routeIs('galeri.*') ? 'color:var(--color-primary)' : '' }}">
                    Galeri
                </a>
                <a href="{{ route('kontak') }}"
                   class="px-3 py-2 rounded-md transition-colors {{ request()->routeIs('kontak') ? '' : 'text-gray-600 hover:text-gray-900' }}"
                   style="{{ request()->routeIs('kontak') ? 'color:var(--color-primary)' : '' }}">
                    Kontak
                </a>
            </div>

            {{-- MOBILE TOGGLE --}}
            <button x-data="" @click="$dispatch('toggle-mobile-menu')"
                    class="lg:hidden flex items-center p-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors border border-gray-200">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-data="{
            open: false,
            profil: false,
            akademik: false
         }"
         @toggle-mobile-menu.window="open = !open"
         class="lg:hidden border-t border-gray-100">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="bg-white shadow-lg divide-y divide-gray-50 max-h-[80vh] overflow-y-auto"
             style="display:none">

            {{-- Beranda --}}
            <a href="{{ route('home') }}"
               class="flex items-center px-5 py-3.5 text-sm font-semibold {{ request()->routeIs('home') ? 'bg-blue-50' : 'text-gray-700 hover:bg-gray-50' }}"
               style="{{ request()->routeIs('home') ? 'color:var(--color-primary)' : '' }}">
                Beranda
            </a>

            {{-- Profil Accordion --}}
            <div>
                <button @click="profil = !profil"
                        class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    <span>Profil</span>
                    <svg class="w-4 h-4 transition-transform" :class="profil && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="profil" class="bg-gray-50" style="display:none">
                    <a href="{{ route('profil.sejarah') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Sejarah Sekolah</a>
                    <a href="{{ route('profil.visi-misi') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Visi &amp; Misi</a>
                    <a href="{{ route('profil.struktur-organisasi') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Guru &amp; Staf</a>
                    <a href="{{ route('profil.fasilitas') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Fasilitas</a>
                </div>
            </div>

            {{-- Akademik Accordion --}}
            <div>
                <button @click="akademik = !akademik"
                        class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    <span>Akademik</span>
                    <svg class="w-4 h-4 transition-transform" :class="akademik && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="akademik" class="bg-gray-50" style="display:none">
                    <a href="{{ route('akademik.kurikulum') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Kurikulum</a>
                    <a href="{{ route('akademik.program-studi') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Program Studi</a>
                    <a href="{{ route('akademik.ekstrakurikuler') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Ekstrakurikuler</a>
                    <a href="{{ route('akademik.kalender') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Kalender Akademik</a>
                    <a href="{{ route('akademik.prestasi') }}" class="flex items-center pl-9 pr-5 py-2.5 text-sm text-gray-600 hover:bg-gray-100" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">Prestasi</a>
                </div>
            </div>

            <a href="{{ route('berita.index') }}"
               class="flex items-center px-5 py-3.5 text-sm font-semibold {{ request()->routeIs('berita.*') ? 'bg-blue-50' : 'text-gray-700 hover:bg-gray-50' }}"
               style="{{ request()->routeIs('berita.*') ? 'color:var(--color-primary)' : '' }}">
                Berita
            </a>
            <a href="{{ route('galeri.index') }}"
               class="flex items-center px-5 py-3.5 text-sm font-semibold {{ request()->routeIs('galeri.*') ? 'bg-blue-50' : 'text-gray-700 hover:bg-gray-50' }}"
               style="{{ request()->routeIs('galeri.*') ? 'color:var(--color-primary)' : '' }}">
                Galeri
            </a>
            <a href="{{ route('kontak') }}"
               class="flex items-center px-5 py-3.5 text-sm font-semibold {{ request()->routeIs('kontak') ? 'bg-blue-50' : 'text-gray-700 hover:bg-gray-50' }}"
               style="{{ request()->routeIs('kontak') ? 'color:var(--color-primary)' : '' }}">
                Kontak
            </a>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="relative text-gray-300 overflow-hidden mt-16" style="background-color: var(--color-primary-dark)">
    {{-- Background pattern overlay --}}
    <div class="absolute inset-0 opacity-80"
         style="background-image: url('{{ asset('images/wheat.webp') }}'); background-repeat: repeat; background-position: top left; background-size: 210px;"></div>
    <div class="absolute inset-0 bg-black/30"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 items-start">

            {{-- Brand col --}}
            <div class="lg:col-span-2 flex flex-col items-start">
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo SMA Negeri 1 Marangkayu"
                         class="w-12 h-12 object-contain" onerror="this.style.display='none'">
                    <div>
                        <div class="font-bold text-lg text-white">SMA Negeri 1 Marangkayu</div>
                        <div class="text-sm text-white/50">Kutai Kartanegara, Kalimantan Timur</div>
                    </div>
                </div>
                {{-- Social icons --}}
                <div class="flex gap-3">
                    <a href="#" target="_blank" rel="noopener noreferrer" title="Facebook"
                       class="w-8 h-8 rounded-full flex items-center justify-center text-white hover:opacity-90 hover:scale-110 transition-all text-sm"
                       style="background:#1877F2">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" title="Instagram"
                       class="w-8 h-8 rounded-full flex items-center justify-center text-white hover:opacity-90 hover:scale-110 transition-all text-sm"
                       style="background:linear-gradient(45deg,#833AB4,#C13584,#E1306C,#FD1D1D,#FCAF45)">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" title="YouTube"
                       class="w-8 h-8 rounded-full flex items-center justify-center text-white hover:opacity-90 hover:scale-110 transition-all text-sm"
                       style="background:#FF0000">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" title="TikTok"
                       class="w-8 h-8 rounded-full flex items-center justify-center text-white hover:opacity-90 hover:scale-110 transition-all text-sm"
                       style="background:#010101">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </div>
            </div>

            {{-- Profil --}}
            <div class="flex flex-col items-start">
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-3">Profil</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('profil.sejarah') }}" class="hover:text-white transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Sejarah Sekolah</a></li>
                    <li><a href="{{ route('profil.visi-misi') }}" class="hover:text-white transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('profil.struktur-organisasi') }}" class="hover:text-white transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Guru &amp; Staf</a></li>
                    <li><a href="{{ route('profil.fasilitas') }}" class="hover:text-white transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Fasilitas</a></li>
                </ul>
            </div>

            {{-- Akademik --}}
            <div class="flex flex-col items-start">
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-3">Akademik</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('akademik.kurikulum') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Kurikulum</a></li>
                    <li><a href="{{ route('akademik.program-studi') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Program Studi</a></li>
                    <li><a href="{{ route('akademik.ekstrakurikuler') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Ekstrakurikuler</a></li>
                    <li><a href="{{ route('akademik.kalender') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Kalender Akademik</a></li>
                    <li><a href="{{ route('akademik.prestasi') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Prestasi</a></li>
                </ul>
            </div>

            {{-- Informasi --}}
            <div class="flex flex-col items-start">
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-3">Informasi</h4>
                <ul class="space-y-2 text-sm text-white/60">
                    <li><a href="{{ route('berita.index') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Berita &amp; Kegiatan</a></li>
                    <li><a href="{{ route('galeri.index') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Galeri Foto</a></li>
                    <li><a href="{{ route('kontak') }}" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Kontak Kami</a></li>
                    <li><a href="https://kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="transition-colors" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color=''">Kemdikbud</a></li>
                </ul>
            </div>

            {{-- CTA / PPDB --}}
            <div class="flex flex-col items-start">
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-3">Penerimaan Siswa</h4>
                <p class="text-sm text-white/60 mb-4 leading-relaxed">
                    Informasi pendaftaran siswa baru dan jadwal PPDB terkini.
                </p>
                <a href="{{ route('kontak') }}"
                   class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-lg transition-all"
                   style="background:#fff ;color:var(--color-primary-dark)">
                    <i class="fa-solid fa-user-plus mr-2"></i>Info PPDB
                </a>
            </div>

        </div>

    </div>
</footer>

{{-- Bottom bar --}}
<div class="text-sm" style="background:#111827">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col md:flex-row items-center justify-between gap-2">
        <p class="text-gray-400">&copy; {{ date('Y') }} SMA Negeri 1 Marangkayu. Hak cipta dilindungi undang-undang.</p>
        <p class="text-gray-400">Dibuat oleh <span class="text-white">arfkimaulana X icong</span></p>
    </div>
</div>

@stack('scripts')
</body>
</html>
