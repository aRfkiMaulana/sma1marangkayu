@extends('layouts.public')
@section('title', 'Galeri - SMA Negeri 1 Marangkayu')

@section('content')
<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="text-center mb-10">
            <h1 class="section-title mx-auto after:mx-auto">Galeri Foto &amp; Video</h1>
            <p class="text-gray-500 mt-3">Dokumentasi kegiatan SMA Negeri 1 Marangkayu</p>
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
                 @if($g->tipe === 'video') onclick="window.open('{{ $g->file }}','_blank')" @endif>
                <img src="{{ $g->tipe === 'foto' ? Storage::url($g->file) : 'https://placehold.co/400x400/1a3d6e/fff?text=Video' }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     alt="{{ $g->judul }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                    <p class="text-white text-xs font-medium line-clamp-2">{{ $g->judul }}</p>
                </div>
                @if($g->tipe === 'video')
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-white/80 flex items-center justify-center">
                        <i class="fa-solid fa-play text-blue-800 ml-1"></i>
                    </div>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-16">
                <i class="fa-solid fa-images text-4xl mb-3 block text-slate-300"></i>
                Galeri masih kosong.
            </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $galeri->links() }}</div>
    </div>
</section>
@endsection
