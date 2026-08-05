@extends('layouts.public')
@section('title', 'Guru & Staf - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Guru &amp; Staf</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="text-center mb-12">
            <h1 class="section-title mx-auto after:mx-auto">Tenaga Pendidik &amp; Staf</h1>
            <p class="text-gray-500 mt-3">SMA Negeri 1 Marangkayu</p>
        </div>

        {{-- GURU --}}
        <div class="mb-14">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm"
                     style="background-color: var(--color-primary)">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <h2 class="text-lg font-bold" style="color: var(--color-primary)">Tenaga Pendidik (Guru)</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
                @forelse($guru as $g)
                <div class="text-center group">
                    <div class="w-20 h-20 rounded-2xl mx-auto mb-3 overflow-hidden ring-2 ring-slate-100 group-hover:ring-blue-300 transition-all">
                        <img src="{{ $g->foto ? Storage::url($g->foto) : 'https://ui-avatars.com/api/?name='.urlencode($g->nama).'&background=1a3d6e&color=fff&size=80' }}"
                             class="w-full h-full object-cover" alt="{{ $g->nama }}">
                    </div>
                    <p class="text-xs font-semibold text-gray-800 leading-snug">{{ $g->nama }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $g->jabatan ?? $g->mata_pelajaran ?? '' }}</p>
                </div>
                @empty
                <div class="col-span-6 text-center text-gray-400 py-10">Data guru belum tersedia.</div>
                @endforelse
            </div>
        </div>

        {{-- STAF --}}
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm"
                     style="background-color: var(--color-accent)">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h2 class="text-lg font-bold" style="color: var(--color-primary)">Staf / Tata Usaha</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
                @forelse($staf as $s)
                <div class="text-center group">
                    <div class="w-20 h-20 rounded-2xl mx-auto mb-3 overflow-hidden ring-2 ring-slate-100 group-hover:ring-yellow-300 transition-all">
                        <img src="{{ $s->foto ? Storage::url($s->foto) : 'https://ui-avatars.com/api/?name='.urlencode($s->nama).'&background=e8a020&color=fff&size=80' }}"
                             class="w-full h-full object-cover" alt="{{ $s->nama }}">
                    </div>
                    <p class="text-xs font-semibold text-gray-800 leading-snug">{{ $s->nama }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $s->jabatan ?? '' }}</p>
                </div>
                @empty
                <div class="col-span-6 text-center text-gray-400 py-10">Data staf belum tersedia.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
