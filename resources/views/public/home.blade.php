@extends('layouts.public')
@section('title', 'Beranda - SMA Negeri 1 Marangkayu')

@section('content')

{{-- HERO SLIDER --}}
<div class="relative overflow-hidden" x-data="slider()" x-init="init()">
    <div class="relative h-[520px]">
        @forelse($sliders as $i => $s)
        <div class="absolute inset-0 transition-opacity duration-700"
             :class="current === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            <img src="{{ Storage::url($s->gambar) }}" class="w-full h-full object-cover"
                 alt="{{ $s->judul }}"
                 onerror="this.src='https://placehold.co/1400x520/1a3d6e/fff?text=SMA+Negeri+1+Marangkayu'">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
            <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                <div class="text-white max-w-3xl">
                    @if($s->judul)
                    <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">{{ $s->judul }}</h1>
                    @endif
                    @if($s->subjudul)
                    <p class="text-lg md:text-xl text-white/90 drop-shadow">{{ $s->subjudul }}</p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="absolute inset-0">
            <img src="https://placehold.co/1400x520/1a3d6e/fff?text=SMA+Negeri+1+Marangkayu"
                 class="w-full h-full object-cover" alt="SMA Negeri 1 Marangkayu">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-center justify-center text-center">
                <div class="text-white">
                    <h1 class="text-4xl font-bold mb-3 drop-shadow-lg">Selamat Datang di SMA Negeri 1 Marangkayu</h1>
                    <p class="text-xl text-white/90">Unggul dalam Prestasi, Mulia dalam Akhlak</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Dots --}}
    @if($sliders->count() > 1)
    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-20">
        @foreach($sliders as $i => $s)
        <button @click="current = {{ $i }}"
                class="w-2.5 h-2.5 rounded-full transition-all"
                :class="current === {{ $i }} ? 'bg-yellow-400 w-6' : 'bg-white/60'"></button>
        @endforeach
    </div>
    {{-- Arrows --}}
    <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center transition-colors">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center transition-colors">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
    @endif
</div>

{{-- STATISTIK --}}
<section class="py-10 bg-slate-50">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php $stats = [
                ['num' => $profil->jumlah_siswa ?? 600, 'label' => 'Siswa Aktif'],
                ['num' => $profil->jumlah_guru ?? 45,  'label' => 'Tenaga Pendidik'],
                ['num' => ($prestasi->count() ?: 50) . '+', 'label' => 'Prestasi'],
                ['num' => ($profil->tahun_berdiri ? date('Y') - $profil->tahun_berdiri : 30) . '+', 'label' => 'Tahun Berdiri'],
            ]; @endphp
            @foreach($stats as $i => $s)
            <div class="rounded-2xl p-6 text-center text-white"
                 style="background:var(--color-primary); background-image: url('{{ asset('images/wheat.webp') }}'); background-repeat: repeat; background-position: 0 0; background-size: 180px 180px; image-rendering: pixelated;">
                <div class="text-3xl font-bold" style="color: var(--color-accent)">{{ $s['num'] }}</div>
                <div class="text-sm text-white/80 mt-1">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
<section class="py-16">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="flex items-end justify-between mb-8">
            <h2 class="section-title">Berita &amp; Pengumuman</h2>
            <a href="{{ route('berita.index') }}" class="btn-outline text-sm py-2 px-4">
                Lihat Semua
            </a>
        </div>

        @if($berita->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($berita as $b)
                <article class="card-hover flex flex-col group">
                    <div class="overflow-hidden h-48">
                        <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/600x350/1a3d6e/fff?text=Berita' }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             alt="{{ $b->judul }}">
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex gap-2 mb-3">
                            <span class="badge badge-primary">{{ ucfirst($b->tipe) }}</span>
                            @if($b->kategori)
                            <span class="badge badge-accent">{{ $b->kategori->nama }}</span>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 leading-snug flex-1 group-hover:text-blue-800 transition-colors">
                            <a href="{{ route('berita.show', $b->slug) }}" class="stretched-link">
                                {{ Str::limit($b->judul, 65) }}
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm mb-4">{{ Str::limit($b->ringkasan ?? strip_tags($b->konten), 90) }}</p>
                        <div class="mt-auto flex items-center gap-2 text-xs text-gray-400">
                            <i class="fa-regular fa-calendar"></i>
                            {{ optional($b->tanggal_publish)->translatedFormat('d M Y') ?? $b->created_at->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 md:p-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                     style="color: var(--color-primary)">
                    <i class="fa-regular fa-newspaper"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700">Belum ada berita terbaru</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Informasi dan pengumuman terbaru akan tampil di sini setelah dipublikasikan.
                </p>
            </div>
        @endif
    </div>
</section>

{{-- VISI MISI --}}
@if($profil && ($profil->visi || $profil->misi))
<section class="py-16 bg-slate-50">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="grid md:grid-cols-2 gap-8 items-stretch">
            <div class="rounded-2xl p-8 text-white flex flex-col"
                 style="background-image: url('{{ asset('images/wheat.webp') }}'); background-repeat: repeat; background-position: 0 0; background-size: 180px 180px; image-rendering: pixelated;">
                <div class="w-12 h-12 rounded-xl mb-5 flex items-center justify-center text-xl"
                     style="background-color: rgba(255,255,255,0.15)">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h3 class="text-lg font-bold" style="color: var(--color-accent)">VISI</h3>
                <p class="text-white/85 leading-relaxed flex-1">{{ $profil->visi ?? 'Belum diisi.' }}</p>
            </div>
            <div class="rounded-2xl p-8 bg-white flex flex-col border border-gray-300">
                <div class="w-12 h-12 rounded-xl mb-5 flex items-center justify-center text-xl"
                     style="background-color: #dbeafe; color: var(--color-primary)">
                    <i class="fa-solid fa-list-check"></i> 
                </div>
                <h3 class="text-lg font-bold " style="color: var(--color-primary)">MISI</h3>
                <div class="text-gray-600 leading-relaxed text-sm flex-1 whitespace-pre-line">{{ $profil->misi ?? 'Belum diisi.' }}</div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- GALERI HIGHLIGHT --}}
<section class="py-16">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="flex items-end justify-between mb-8">
            <h2 class="section-title">Galeri Foto</h2>
            <a href="{{ route('galeri.index') }}" class="btn-outline text-sm py-2 px-4">
                Lihat Semua
            </a>
        </div>

        @if($galeri->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($galeri as $g)
                <div class="overflow-hidden rounded-xl group cursor-pointer aspect-square">
                    <img src="{{ $g->tipe === 'foto' ? Storage::url($g->file) : 'https://placehold.co/400x400/1a3d6e/fff?text=Video' }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         alt="{{ $g->judul }}">
                </div>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 md:p-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                     style="color: var(--color-primary)">
                    <i class="fa-regular fa-image"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700">Belum ada highlight galeri</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Foto atau video unggulan akan ditampilkan di sini setelah ditambahkan.
                </p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
function slider() {
    return {
        current: 0,
        total: {{ $sliders->count() ?: 1 }},
        timer: null,
        init() { if(this.total > 1) this.timer = setInterval(() => this.next(), 5000); },
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; }
    }
}
</script>
@endpush
@endsection
