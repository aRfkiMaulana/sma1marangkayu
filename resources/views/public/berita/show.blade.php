@extends('layouts.public')
@section('title', $berita->judul . ' - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <a href="{{ route('berita.index') }}" class="hover:text-blue-800">Berita</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium truncate max-w-xs">{{ $berita->judul }}</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="grid lg:grid-cols-3 gap-10">
            {{-- ARTIKEL --}}
            <div class="lg:col-span-2">
                @if($berita->thumbnail)
                <img src="{{ Storage::url($berita->thumbnail) }}"
                     class="w-full h-80 object-cover rounded-2xl mb-6" alt="{{ $berita->judul }}">
                @endif

                <div class="flex gap-2 mb-4 flex-wrap">
                    <span class="badge badge-primary">{{ ucfirst($berita->tipe) }}</span>
                    @if($berita->kategori)
                    <span class="badge badge-accent">{{ $berita->kategori->nama }}</span>
                    @endif
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $berita->judul }}</h1>

                <div class="flex items-center gap-4 text-sm text-gray-400 mb-8 pb-6 border-b border-slate-200">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar"></i>
                        {{ optional($berita->tanggal_publish)->translatedFormat('d F Y') ?? $berita->created_at->translatedFormat('d F Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-eye"></i>
                        {{ number_format($berita->views) }} dilihat
                    </span>
                </div>

                <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed">
                    {!! $berita->konten !!}
                </div>
            </div>

            {{-- SIDEBAR --}}
            <aside>
                <div class="rounded-xl overflow-hidden shadow-sm border border-slate-100 sticky top-24">
                    <div class="px-4 py-3 text-sm font-bold text-white" style="background-color: var(--color-primary)">
                        Berita Terkait
                    </div>
                    @forelse($related as $r)
                    <a href="{{ route('berita.show', $r->slug) }}"
                       class="flex gap-3 px-4 py-3 border-b border-slate-100 hover:bg-blue-50 transition-colors group last:border-0">
                        <img src="{{ $r->thumbnail ? Storage::url($r->thumbnail) : 'https://placehold.co/80x60/1a3d6e/fff?text=B' }}"
                             class="w-16 h-14 rounded-lg object-cover flex-shrink-0" alt="">
                        <div>
                            <p class="text-xs font-medium text-gray-800 group-hover:text-blue-800 leading-snug">{{ Str::limit($r->judul, 60) }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ optional($r->tanggal_publish)->translatedFormat('d M Y') }}</p>
                        </div>
                    </a>
                    @empty
                    <p class="px-4 py-4 text-sm text-gray-400">Tidak ada berita terkait.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
