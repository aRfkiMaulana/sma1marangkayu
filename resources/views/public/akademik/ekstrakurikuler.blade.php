@extends('layouts.public')
@section('title', 'Ekstrakurikuler - SMA Negeri 1 Marangkayu')

@section('content')
@include('public.akademik._subnav')

<section class="py-10 min-h-[400px] bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        @if($ekskul->isEmpty())
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-8 md:p-12 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-50 text-2xl"
                 style="color:var(--color-primary)">
                <i class="fa-solid fa-star"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700">Belum ada ekstrakurikuler</h3>
            <p class="mt-2 text-sm text-gray-500">Data kegiatan ekstrakurikuler akan tampil di sini setelah ditambahkan.</p>
        </div>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($ekskul as $e)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col">

                {{-- Header card --}}
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

                    {{-- Body card --}}
                    <div class=" space-y-2 flex flex-col flex-1">

                        {{-- Pembina --}}
                        @if($e->pembina)
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <i class="fa-solid fa-chalkboard-user w-4 shrink-0" style="color:var(--color-primary)"></i>
                            <span>{{ $e->pembina }}<span class="text-gray-400"> · Pembina</span></span>
                        </div>
                        @endif

                        @if($e->jadwal)
                        <div class=" border-t border-gray-200">
                            <span class="flex items-center gap-2 text-sm text-gray-700 mt-2">
                                {{ $e->jadwal }}
                            </span>
                        </div>
                        @endif
                    </div>


                    {{-- Personel accordion --}}
                    @if($e->personel->isNotEmpty())
                    <details class="pt-2 border-t border-gray-200 group mt-auto">
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
            </div>
            @endforeach
        </div>
        @endif

    </div>
</section>

@endsection
