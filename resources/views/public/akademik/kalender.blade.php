@extends('layouts.public')
@section('title', 'Kalender Akademik - SMA Negeri 1 Marangkayu')

@section('content')

@include('public.akademik._subnav')

<section class="py-14">
    <div class="container mx-auto max-w-5xl px-4">
        <div class="text-center mb-10">
            <h1 class="section-title mx-auto after:mx-auto mb-4">Kalender Akademik</h1>
            <p class="text-gray-500 text-sm">Kalender akademik resmi SMAN 1 Marangkayu</p>
        </div>

        @if($data && $data->file_lampiran)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 md:p-6 overflow-hidden text-center">
            <img src="{{ Storage::url($data->file_lampiran) }}" alt="Kalender Akademik SMAN 1 Marangkayu" class="w-full h-auto rounded-xl mx-auto border border-slate-100 shadow-sm">
            <div class="mt-6">
                <a href="{{ Storage::url($data->file_lampiran) }}" download class="btn-primary inline-flex items-center gap-2">
                    <i class="fa-solid fa-download"></i> Unduh Gambar Kalender Akademik
                </a>
            </div>
        </div>
        @else
        <div class="rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 md:p-12 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                 style="color:var(--color-primary)">
                <i class="fa-regular fa-calendar"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700">Belum Ada Kalender Akademik</h3>
            <p class="mt-2 text-sm text-gray-500">Gambar kalender akademik belum diunggah oleh admin.</p>
        </div>
        @endif
    </div>
</section>
@endsection
