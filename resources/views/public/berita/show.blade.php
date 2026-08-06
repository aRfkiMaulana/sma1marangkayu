@extends('layouts.public')
@section('title', $berita->judul . ' - SMA Negeri 1 Marangkayu')

@section('content')
<section class="py-8 pb-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- ── KONTEN UTAMA ────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-300 overflow-hidden">
                    @if($berita->thumbnail)
                        <div class="aspect-[16/9] overflow-hidden">
                            <img src="{{ Storage::url($berita->thumbnail) }}"
                                 alt="{{ $berita->judul }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-[16/9] flex items-center justify-center"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light))">
                            <div class="text-center">
                                <i class="fa-solid fa-newspaper text-6xl text-white/80 mb-3 block"></i>
                                <p class="text-white/70 text-sm font-medium">{{ $berita->judul }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="px-6 py-4 flex flex-wrap gap-2 border-b border-gray-100">
                        <span class="badge badge-primary text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">
                            {{ ucfirst($berita->tipe) }}
                        </span>
                        @if($berita->kategori)
                            <span class="badge badge-accent text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">
                                {{ $berita->kategori->nama }}
                            </span>
                        @endif
                        <span class="badge bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fa-regular fa-calendar mr-1"></i>
                            {{ optional($berita->tanggal_publish)->translatedFormat('d F Y') ?? $berita->created_at->translatedFormat('d F Y') }}
                        </span>
                        <span class="badge bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fa-regular fa-eye mr-1"></i>
                            {{ number_format($berita->views) }} dilihat
                        </span>
                    </div>

                    <div class="px-6 py-5">
                        <h1 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">{{ $berita->judul }}</h1>

                        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                            {!! $berita->konten !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SIDEBAR ──────────────────────────────────── --}}
            <div class="space-y-5 lg:sticky lg:top-24 self-start">
                <div class="bg-white rounded-2xl border border-gray-300 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Berita Terkait</p>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($related as $r)
                            <a href="{{ route('berita.show', $r->slug) }}"
                               class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                                <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0 flex-shrink-0">
                                    @if($r->thumbnail)
                                        <img src="{{ Storage::url($r->thumbnail) }}" alt="{{ $r->judul }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center"
                                             style="background:var(--color-primary)">
                                            <i class="fa-solid fa-newspaper text-white text-sm"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-800 group-hover:text-blue-800 leading-snug line-clamp-2">
                                        {{ Str::limit($r->judul, 60) }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ optional($r->tanggal_publish)->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <p class="px-5 py-4 text-sm text-gray-400">Tidak ada berita terkait.</p>
                        @endforelse
                    </div>
                </div>

                <a href="{{ route('berita.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white rounded-2xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Kembali ke Daftar Berita
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
