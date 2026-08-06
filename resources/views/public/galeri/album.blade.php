@extends('layouts.public')
@section('title', 'Album: ' . $album . ' - SMA Negeri 1 Marangkayu')

@section('content')
<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="flex items-center gap-3 mb-8">
            <h1 class="section-title">Album: {{ $album }}</h1>
        </div>

        {{-- ALBUM LAIN --}}
        @if($semua->count() > 1)
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('galeri.index') }}"
               class="px-4 py-1.5 rounded-full text-sm border border-slate-300 text-gray-600 hover:border-blue-800 hover:text-blue-800 transition-colors">
                Semua
            </a>
            @foreach($semua as $a)
            <a href="{{ route('galeri.album', $a) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors {{ $a === $album ? 'text-white' : 'border border-slate-300 text-gray-600 hover:border-blue-800 hover:text-blue-800' }}"
               @if($a === $album) style="background-color: var(--color-primary)" @endif>
                {{ $a }}
            </a>
            @endforeach
        </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @forelse($galeri as $g)
            <div class="group relative overflow-hidden rounded-xl aspect-square cursor-pointer"
                 data-lightbox-src="{{ Storage::url($g->file) }}"
                 data-lightbox-caption="{{ $g->judul }}"
                 data-lightbox-group="galeri-album">
                <img src="{{ Storage::url($g->file) }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     alt="{{ $g->judul }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                    <p class="text-white text-xs font-medium">{{ Str::limit($g->judul, 40) }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-4 rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                     style="color:var(--color-primary)">
                    <i class="fa-solid fa-images"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700">Album ini kosong</h3>
                <p class="mt-2 text-sm text-gray-500">Belum ada foto dalam album ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
