@extends('layouts.public')
@section('title', $prestasi->judul . ' - SMA Negeri 1 Marangkayu')

@section('content')

@include('public.akademik._subnav')

<section class="py-8 pb-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- ── KONTEN UTAMA ────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Hero foto / trophy --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    @if($prestasi->foto)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($prestasi->foto) }}"
                                 alt="{{ $prestasi->judul }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-video flex items-center justify-center"
                             style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light))">
                            <div class="text-center">
                                <i class="fa-solid fa-trophy text-6xl text-yellow-400 mb-3 block"></i>
                                <p class="text-white/70 text-sm font-medium">{{ $prestasi->judul }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Badge di bawah foto --}}
                    <div class="px-6 py-4 flex flex-wrap gap-2 border-b border-gray-100">
                        @php
                            $tingkatColor = match($prestasi->tingkat) {
                                'internasional' => 'bg-purple-100 text-purple-700',
                                'nasional'      => 'bg-red-100 text-red-700',
                                'provinsi'      => 'bg-orange-100 text-orange-700',
                                'kabupaten'     => 'bg-blue-100 text-blue-700',
                                'kecamatan'     => 'bg-cyan-100 text-cyan-700',
                                default         => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="badge {{ $tingkatColor }} text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">
                            {{ ucfirst($prestasi->tingkat) }}
                        </span>
                        <span class="badge bg-amber-100 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">
                            {{ ucfirst(str_replace('_', ' ', $prestasi->kategori)) }}
                        </span>
                        <span class="badge bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fa-regular fa-calendar mr-1"></i>{{ $prestasi->tahun }}
                        </span>
                    </div>

                    {{-- Judul & konten --}}
                    <div class="px-6 py-5">
                        <h1 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">{{ $prestasi->judul }}</h1>

                        @if($prestasi->peraih)
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-5">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white shrink-0"
                                 style="background:var(--color-primary)">
                                <i class="fa-solid fa-user text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Peraih</p>
                                <p class="font-semibold text-gray-800">{{ $prestasi->peraih }}</p>
                            </div>
                        </div>
                        @endif

                        @if($prestasi->deskripsi)
                        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($prestasi->deskripsi)) !!}
                        </div>
                        @else
                        <p class="text-gray-400 text-sm italic">Deskripsi belum tersedia.</p>
                        @endif
                    </div>
                </div>

            </div>

            {{-- ── SIDEBAR ──────────────────────────────────── --}}
            <div class="space-y-5">

                {{-- Detail info --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100"
                         style="background:linear-gradient(to right, color-mix(in srgb, var(--color-primary) 8%, white), white)">
                        <p class="text-xs font-bold uppercase tracking-wide" style="color:var(--color-primary)">
                            Detail Prestasi
                        </p>
                    </div>
                    <div class="divide-y divide-gray-50 text-sm">
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">Tingkat</span>
                            <span class="font-semibold text-gray-900">{{ ucfirst($prestasi->tingkat) }}</span>
                        </div>
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $prestasi->kategori)) }}</span>
                        </div>
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">Tahun</span>
                            <span class="font-semibold text-gray-900">{{ $prestasi->tahun }}</span>
                        </div>
                        @if($prestasi->peraih)
                        <div class="flex items-start justify-between px-5 py-3 gap-3">
                            <span class="text-gray-500 shrink-0">Peraih</span>
                            <span class="font-semibold text-gray-900 text-right">{{ $prestasi->peraih }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Prestasi lainnya --}}
                @if($lainnya->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Prestasi Lainnya</p>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($lainnya as $l)
                        <a href="{{ route('akademik.prestasi.show', $l) }}"
                           class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 flex-shrink-0">
                                @if($l->foto)
                                    <img src="{{ Storage::url($l->foto) }}" alt="{{ $l->judul }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background:var(--color-primary)">
                                        <i class="fa-solid fa-trophy text-yellow-400 text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-800 group-hover:text-blue-800 leading-snug line-clamp-2">
                                    {{ $l->judul }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $l->tahun }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100">
                        <a href="{{ route('akademik.prestasi') }}"
                           class="text-xs font-semibold transition-colors"
                           style="color:var(--color-primary)"
                           onmouseover="this.style.color='var(--color-primary-dark)'"
                           onmouseout="this.style.color='var(--color-primary)'">
                            Lihat semua prestasi →
                        </a>
                    </div>
                </div>
                @endif

                {{-- Kembali --}}
                <a href="{{ route('akademik.prestasi') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white rounded-2xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Kembali ke Daftar Prestasi
                </a>

            </div>
        </div>
    </div>
</section>

@endsection
