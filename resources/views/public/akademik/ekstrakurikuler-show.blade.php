@extends('layouts.public')
@section('title', $ekstrakurikuler->nama . ' - SMA Negeri 1 Marangkayu')

@section('content')

@include('public.akademik._subnav')

<section class="py-8 pb-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- ── KONTEN UTAMA ────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Hero --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

                    {{-- Banner --}}
                    @if($ekstrakurikuler->foto)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ Storage::url($ekstrakurikuler->foto) }}"
                             alt="{{ $ekstrakurikuler->nama }}"
                             class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="relative h-48 flex items-center px-8 overflow-hidden"
                         style="background:var(--color-primary)">
                        <div class="absolute inset-0"
                             style="background-image:url('{{ asset('images/pattern.png') }}'); background-repeat:repeat; background-size:80px; opacity:0.15;"></div>
                        <div class="absolute inset-0 bg-black/30"></div>
                        <div class="relative flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">
                                <i class="fa-solid fa-star text-white text-3xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">{{ $ekstrakurikuler->nama }}</h1>
                                @if($ekstrakurikuler->jadwal)
                                <p class="text-white/70 text-sm mt-1">
                                    <i class="fa-regular fa-clock mr-1"></i>{{ $ekstrakurikuler->jadwal }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Info singkat --}}
                    <div class="px-6 py-5">
                        @if($ekstrakurikuler->foto)
                        <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $ekstrakurikuler->nama }}</h1>
                        @endif

                        <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-5">
                            @if($ekstrakurikuler->pembina)
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-chalkboard-user shrink-0" style="color:var(--color-primary)"></i>
                                <span><span class="font-medium">Pembina:</span> {{ $ekstrakurikuler->pembina }}</span>
                            </div>
                            @endif
                            @if($ekstrakurikuler->jadwal)
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-clock shrink-0" style="color:var(--color-primary)"></i>
                                <span><span class="font-medium">Jadwal:</span> {{ $ekstrakurikuler->jadwal }}</span>
                            </div>
                            @endif
                            @if($ekstrakurikuler->personel->isNotEmpty())
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-users shrink-0" style="color:var(--color-primary)"></i>
                                <span><span class="font-medium">Personel:</span> {{ $ekstrakurikuler->personel->count() }} orang</span>
                            </div>
                            @endif
                        </div>

                        @if($ekstrakurikuler->deskripsi)
                        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($ekstrakurikuler->deskripsi)) !!}
                        </div>
                        @else
                        <p class="text-gray-400 text-sm italic">Deskripsi belum tersedia.</p>
                        @endif
                    </div>
                </div>

                {{-- Personel / Anggota --}}
                @if($ekstrakurikuler->personel->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-users" style="color:var(--color-primary)"></i>
                        Personel &amp; Anggota
                    </h2>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($ekstrakurikuler->personel as $i => $p)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                 style="background:var(--color-primary)">
                                {{ $i + 1 }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate">{{ $p->nama }}</p>
                                @if($p->jabatan)
                                <p class="text-xs text-gray-500">{{ $p->jabatan }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Prestasi ekskul ini --}}
                @if($ekstrakurikuler->prestasi->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-trophy" style="color:var(--color-accent)"></i>
                        Prestasi
                    </h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach($ekstrakurikuler->prestasi as $pr)
                        <a href="{{ route('akademik.prestasi.show', $pr) }}"
                           class="flex gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-yellow-300 hover:bg-amber-50 transition-colors group">
                            <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0">
                                @if($pr->foto)
                                    <img src="{{ Storage::url($pr->foto) }}" alt="{{ $pr->judul }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background:var(--color-primary)">
                                        <i class="fa-solid fa-trophy text-yellow-400 text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 group-hover:text-blue-800 leading-snug line-clamp-2">
                                    {{ $pr->judul }}
                                </p>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                        {{ match($pr->tingkat) {
                                            'internasional' => 'bg-purple-100 text-purple-700',
                                            'nasional'      => 'bg-red-100 text-red-700',
                                            'provinsi'      => 'bg-orange-100 text-orange-700',
                                            'kabupaten'     => 'bg-blue-100 text-blue-700',
                                            default         => 'bg-gray-100 text-gray-600',
                                        } }}">
                                        {{ ucfirst($pr->tingkat) }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $pr->tahun }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- ── SIDEBAR ──────────────────────────────────── --}}
            <div class="space-y-5">

                {{-- Info card --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100"
                         style="background:linear-gradient(to right, color-mix(in srgb, var(--color-primary) 8%, white), white)">
                        <p class="text-xs font-bold uppercase tracking-wide" style="color:var(--color-primary)">
                            Info Ekstrakurikuler
                        </p>
                    </div>
                    <div class="divide-y divide-gray-50 text-sm">
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">Nama</span>
                            <span class="font-semibold text-gray-900 text-right max-w-[60%]">{{ $ekstrakurikuler->nama }}</span>
                        </div>
                        @if($ekstrakurikuler->pembina)
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">Pembina</span>
                            <span class="font-semibold text-gray-900 text-right max-w-[60%]">{{ $ekstrakurikuler->pembina }}</span>
                        </div>
                        @endif
                        @if($ekstrakurikuler->jadwal)
                        <div class="flex items-start justify-between px-5 py-3 gap-3">
                            <span class="text-gray-500 shrink-0">Jadwal</span>
                            <span class="font-semibold text-gray-900 text-right">{{ $ekstrakurikuler->jadwal }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">Personel</span>
                            <span class="font-semibold text-gray-900">{{ $ekstrakurikuler->personel->count() }} orang</span>
                        </div>
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">Prestasi</span>
                            <span class="font-semibold text-gray-900">{{ $ekstrakurikuler->prestasi->count() }} prestasi</span>
                        </div>
                    </div>
                </div>

                {{-- Ekskul lainnya --}}
                @if($lainnya->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Ekskul Lainnya</p>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($lainnya as $l)
                        <a href="{{ route('akademik.ekstrakurikuler.show', $l) }}"
                           class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                            <div class="w-9 h-9 rounded-lg overflow-hidden shrink-0">
                                @if($l->foto)
                                    <img src="{{ Storage::url($l->foto) }}" alt="{{ $l->nama }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                         style="background:var(--color-primary)">
                                        <i class="fa-solid fa-star text-white text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-700 group-hover:text-blue-800 truncate">
                                    {{ $l->nama }}
                                </p>
                                @if($l->jadwal)
                                <p class="text-xs text-gray-400 truncate">{{ $l->jadwal }}</p>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100">
                        <a href="{{ route('akademik.ekstrakurikuler') }}"
                           class="text-xs font-semibold transition-colors"
                           style="color:var(--color-primary)">
                            Lihat semua ekstrakurikuler →
                        </a>
                    </div>
                </div>
                @endif

                {{-- Kembali --}}
                <a href="{{ route('akademik.ekstrakurikuler') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white rounded-2xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Kembali ke Daftar Ekskul
                </a>

            </div>
        </div>
    </div>
</section>

@endsection
