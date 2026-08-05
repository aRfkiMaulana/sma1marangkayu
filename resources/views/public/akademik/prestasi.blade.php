@extends('layouts.public')
@section('title', 'Prestasi - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Prestasi</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="text-center mb-12">
            <h1 class="section-title mx-auto after:mx-auto">Prestasi Sekolah</h1>
            <p class="text-gray-500 mt-3">Pencapaian terbaik SMA Negeri 1 Marangkayu</p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($prestasi as $p)
            <div class="card-hover group">
                @if($p->foto)
                <div class="overflow-hidden h-40">
                    <img src="{{ Storage::url($p->foto) }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         alt="{{ $p->judul }}">
                </div>
                @else
                <div class="h-40 flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light))">
                    <i class="fa-solid fa-trophy text-4xl text-yellow-400"></i>
                </div>
                @endif
                <div class="p-4">
                    <div class="flex flex-wrap gap-1.5 mb-2">
                        <span class="badge badge-accent">{{ ucfirst($p->tingkat) }}</span>
                        <span class="badge bg-blue-100 text-blue-700">{{ ucfirst(str_replace('_',' ',$p->kategori)) }}</span>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm mb-1 leading-snug">{{ $p->judul }}</h3>
                    @if($p->peraih)
                    <p class="text-xs text-gray-500 flex items-center gap-1.5 mb-1">
                        <i class="fa-solid fa-user text-slate-400"></i> {{ $p->peraih }}
                    </p>
                    @endif
                    <p class="text-xs text-gray-400 flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar text-slate-400"></i> {{ $p->tahun }}
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-16">
                <i class="fa-solid fa-trophy text-4xl mb-3 block text-slate-300"></i>
                Data prestasi belum tersedia.
            </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $prestasi->links() }}</div>
    </div>
</section>
@endsection
