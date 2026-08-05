@extends('layouts.public')
@section('title', 'Ekstrakurikuler - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Ekstrakurikuler</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="text-center mb-12">
            <h1 class="section-title mx-auto after:mx-auto">Ekstrakurikuler</h1>
            <p class="text-gray-500 mt-3">Kegiatan pengembangan diri siswa SMA Negeri 1 Marangkayu</p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($ekskul as $e)
            <div class="card-hover group">
                <div class="overflow-hidden h-40">
                    <img src="{{ $e->foto ? Storage::url($e->foto) : 'https://placehold.co/400x260/1a3d6e/fff?text='.urlencode($e->nama) }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         alt="{{ $e->nama }}">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $e->nama }}</h3>
                    @if($e->pembina)
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 mb-1">
                        <i class="fa-solid fa-user text-slate-400"></i> {{ $e->pembina }}
                    </p>
                    @endif
                    @if($e->jadwal)
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 mb-2">
                        <i class="fa-regular fa-clock text-slate-400"></i> {{ $e->jadwal }}
                    </p>
                    @endif
                    @if($e->deskripsi)
                    <p class="text-xs text-gray-500 leading-relaxed">{{ Str::limit($e->deskripsi, 80) }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-16">
                <i class="fa-solid fa-star text-4xl mb-3 block text-slate-300"></i>
                Data ekstrakurikuler belum tersedia.
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
