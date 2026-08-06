@extends('layouts.public')
@section('title', 'Ekstrakurikuler - SMA Negeri 1 Marangkayu')

@section('content')
@include('public.akademik._subnav')

{{-- ── RANGKING EKSTRAKURIKULER ── --}}
@if($rangking->isNotEmpty() && $rangking->first()->skor_prestasi > 0)
<section class="py-8 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        <h2 class="text-3xl font-bold mb-5 flex items-center gap-2" style="color:var(--color-primary)">
            <x-icons.index name="peringkat" width="60px" height="60px" />
            Peringkat Ekstrakurikuler
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($rangking as $i => $r)
            @php
                $medals = ['🥇','🥈','🥉'];
                $medal  = $medals[$i] ?? null;
            @endphp
            <a href="{{ route('akademik.ekstrakurikuler.show', $r) }}"
               class="bg-white rounded-2xl ring-2 overflow-hidden flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-200 group"
               style="--tw-ring-color: var(--color-primary);">

                {{-- Foto --}}
                <div class="relative overflow-hidden">
                    @if($r->foto)
                        <img src="{{ Storage::url($r->foto) }}" alt="{{ $r->nama }}"
                             class="w-full h-32 object-cover transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="w-full h-32 bg-slate-100 flex items-center justify-center">
                            <i class="fa-solid fa-star text-3xl text-gray-300"></i>
                        </div>
                    @endif

                    {{-- Badge peringkat --}}
                    <div class="absolute top-2 left-2">
                        @if($medal)
                            <span class="text-xl leading-none drop-shadow">{{ $medal }}</span>
                        @else
                            <span class="text-xs font-bold bg-white/80 backdrop-blur-sm rounded-full px-2 py-0.5 text-gray-600">
                                #{{ $i + 1 }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-3 flex flex-col flex-1">
                    <p class="font-bold text-xs uppercase text-gray-800 leading-snug group-hover:text-blue-800 transition-colors line-clamp-2">
                        {{ $r->nama }}
                    </p>
                    <div class="mt-auto pt-2 flex items-center justify-between">
                        <span class="text-xs text-gray-400">{{ $r->prestasi->count() }} prestasi</span>
                        <span class="text-xs font-bold" style="color:var(--color-primary)">
                            {{ number_format($r->skor_prestasi) }} poin
                        </span>
                    </div>
                </div>

            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        <h2 class="text-3xl font-bold mb-5 flex items-center" style="color:var(--color-primary)">
            <x-icons.index name="rocket" width="70px" height="70px" />
            Daftar Ekstrakurikuler
        </h2>

        @if($ekskul->isEmpty())
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-8 md:p-12 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-50">
                <x-icons.index name="ekskul-mascot" width="50px" height="50px" />
            </div>
            <h3 class="text-xl font-semibold text-gray-700">Belum ada ekstrakurikuler</h3>
            <p class="mt-2 text-sm text-gray-500">Data kegiatan ekstrakurikuler akan tampil di sini setelah ditambahkan.</p>
        </div>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($ekskul as $e)
            <a href="{{ route('akademik.ekstrakurikuler.show', $e) }}"
               class="bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">

                {{-- Foto --}}
                <div class="overflow-hidden">
                    @if($e->foto)
                        <img src="{{ Storage::url($e->foto) }}" alt="{{ $e->nama }}"
                             class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-slate-200 flex items-center justify-center">
                            <i class="fa-solid fa-star text-2xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <div class="p-4 space-y-2 flex flex-col flex-1 ml-1">
                    <div>
                        <p class="font-bold uppercase text-gray-900 text-sm leading-snug">{{ $e->nama }}</p>
                    </div>

                    <div class="space-y-2 flex flex-col flex-1">
                        {{-- Pembina --}}
                        @if($e->pembina)
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <i class="fa-solid fa-chalkboard-user w-4 shrink-0" style="color:var(--color-primary)"></i>
                            <span>{{ $e->pembina }}<span class="text-gray-400"> · Pembina</span></span>
                        </div>
                        @endif

                        @if($e->jadwal)
                        <div class="border-t border-gray-200">
                            <span class="flex items-center gap-2 text-sm text-gray-700 mt-2">{{ $e->jadwal }}</span>
                        </div>
                        @endif
                    </div>

                    {{-- Personel accordion --}}
                    @if($e->personel->isNotEmpty())
                    <details class="pt-2 border-t border-gray-200 group mt-auto"
                             onclick="event.preventDefault(); event.stopPropagation(); this.open = !this.open;">
                        <summary class="cursor-pointer list-none flex items-center justify-between gap-2 text-xs font-semibold"
                                 style="color:var(--color-primary)">
                            <span>Lihat {{ $e->personel->count() }} personel</span>
                            <svg class="w-4 h-4 transition-transform group-open:rotate-180 shrink-0"
                                 fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="mt-3 max-h-56 overflow-y-auto rounded-lg border border-gray-200 divide-y divide-gray-50">
                            @foreach($e->personel as $p)
                            <div class="px-3 py-2 text-xs">
                                <p class="font-semibold text-gray-800">{{ $p->nama }}</p>
                                @if($p->jabatan)
                                <p class="text-gray-500">{{ $p->jabatan }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </details>
                    @endif

                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</section>

@endsection
