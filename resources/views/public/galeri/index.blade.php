@extends('layouts.public')
@section('title', 'Galeri - SMA Negeri 1 Marangkayu')

@section('content')
<section class="py-10">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="text-center mb-7">
            <h1 class="section-title mx-auto after:mx-auto">Galeri Foto</h1>
            <p class="text-gray-500 ">Dokumentasi kegiatan SMA Negeri 1 Marangkayu</p>
        </div>

        {{-- FILTER ALBUM --}}
        @if($album->count())
        <div class="flex flex-wrap gap-2 justify-center mb-8">
            <a href="{{ route('galeri.index') }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors text-white"
               style="background-color: var(--color-primary)">
                Semua
            </a>
            @foreach($album as $a)
            <a href="{{ route('galeri.album', $a) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium border border-slate-300 text-gray-600 hover:border-blue-800 hover:text-blue-800 transition-colors">
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
                 data-lightbox-group="galeri-index">
                <img src="{{ Storage::url($g->file) }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     alt="{{ $g->judul }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                    <p class="text-white text-xs font-medium line-clamp-2">{{ $g->judul }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-4 rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 md:p-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                     style="color:var(--color-primary)">
                    <i class="fa-solid fa-images"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700">Galeri masih kosong</h3>
                <p class="mt-2 text-sm text-gray-500">Foto dokumentasi kegiatan sekolah akan tampil di sini.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $galeri->links() }}</div>
    </div>
</section>

@endsection
