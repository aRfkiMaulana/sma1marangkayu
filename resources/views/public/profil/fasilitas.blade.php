@extends('layouts.public')
@section('title', 'Fasilitas - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Fasilitas</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="text-center mb-12">
            <h1 class="section-title mx-auto after:mx-auto">Fasilitas Sekolah</h1>
            <p class="text-gray-500 mt-3">Sarana dan prasarana SMA Negeri 1 Marangkayu</p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($fasilitas as $f)
            <div class="card-hover group">
                <div class="overflow-hidden h-44">
                    <img src="{{ $f->foto ? Storage::url($f->foto) : 'https://placehold.co/400x260/1a3d6e/fff?text='.urlencode($f->nama) }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         alt="{{ $f->nama }}">
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="font-semibold text-gray-800 text-sm">{{ $f->nama }}</h3>
                        @if($f->jumlah > 1)
                        <span class="badge badge-primary flex-shrink-0">{{ $f->jumlah }} unit</span>
                        @endif
                    </div>
                    @if($f->kategori)
                    <p class="text-xs text-gray-400 mb-1">{{ $f->kategori }}</p>
                    @endif
                    @if($f->deskripsi)
                    <p class="text-xs text-gray-500 leading-relaxed">{{ Str::limit($f->deskripsi, 80) }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-16">
                <i class="fa-solid fa-building text-4xl mb-3 block text-slate-300"></i>
                Data fasilitas belum tersedia.
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
