@extends('layouts.public')
@section('title', 'Guru & Staf - SMA Negeri 1 Marangkayu')

@section('content')
@include('public.profil._subnav')

<section class="py-10">
    <div class="container mx-auto max-w-7xl px-4">

        {{-- GURU --}}
        <div class="mb-14">
            <div class="flex items-center gap-3">
                <h2 class="text-3xl font-bold mb-5 flex items-center gap-2" style="color:var(--color-primary)">
                    <x-icons.index name="ekskul-mascot" width="60px" height="60px" />
                    Tenaga Pendidik / Guru
                </h2>
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
                <div class="col-span-6 rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                         style="color:var(--color-primary)">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700">Belum ada data guru</h3>
                    <p class="mt-2 text-sm text-gray-500">Data tenaga pendidik akan tampil di sini setelah ditambahkan.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- STAF --}}
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-3xl font-bold mb-5 flex items-center gap-2" style="color:var(--color-primary)">
                    <x-icons.index name="staf" width="65px" height="65px" />
                    Staf / Tata Usaha
                </h2>
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
                <div class="col-span-6 rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                         style="color:var(--color-primary)">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700">Belum ada data staf</h3>
                    <p class="mt-2 text-sm text-gray-500">Data staf dan tata usaha akan tampil di sini setelah ditambahkan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
