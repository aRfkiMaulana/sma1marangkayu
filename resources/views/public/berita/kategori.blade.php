@extends('layouts.public')
@section('title', 'Kategori: ' . $kategori->nama . ' - SMA Negeri 1 Marangkayu')

@section('content')
<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <h2 class="section-title mb-8">Kategori: {{ $kategori->nama }}</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($berita as $b)
            <article class="card-hover flex flex-col group">
                <div class="overflow-hidden h-44">
                    <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/600x350/1a3d6e/fff?text=Berita' }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $b->judul }}">
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <span class="badge badge-primary mb-2 self-start">{{ ucfirst($b->tipe) }}</span>
                    <h3 class="font-semibold text-gray-800 text-sm mb-2 flex-1 group-hover:text-blue-800 transition-colors">
                        <a href="{{ route('berita.show', $b->slug) }}">{{ Str::limit($b->judul, 65) }}</a>
                    </h3>
                    <p class="text-gray-500 text-xs">{{ Str::limit(strip_tags($b->konten), 90) }}</p>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center text-gray-400 py-16">
                Belum ada berita dalam kategori ini.
            </div>
            @endforelse
        </div>
        <div class="mt-8">{{ $berita->links() }}</div>
    </div>
</section>
@endsection
