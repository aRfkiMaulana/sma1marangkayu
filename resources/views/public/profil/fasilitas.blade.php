@extends('layouts.public')
@section('title', 'Fasilitas - SMA Negeri 1 Marangkayu')

@section('content')
@include('public.profil._subnav')

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
            <div class="col-span-4 rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 md:p-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                     style="color:var(--color-primary)">
                    <i class="fa-solid fa-building"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700">Belum ada data fasilitas</h3>
                <p class="mt-2 text-sm text-gray-500">Sarana dan prasarana sekolah akan tampil di sini setelah ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
