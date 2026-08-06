@extends('layouts.public')
@section('title', 'Kalender Akademik - SMA Negeri 1 Marangkayu')

@section('content')

@include('public.akademik._subnav')

<section class="py-14">
    <div class="container mx-auto max-w-4xl px-4">
        <div class="text-center mb-10">
            <h1 class="section-title mx-auto after:mx-auto mb-8">Kalender Akademik</h1>
            @if($data)
            <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed">
                {!! $data->konten !!}
            </div>
            @if($data->file_lampiran)
            <div class="mt-6 pt-6 border-t border-slate-100">
                <a href="{{ Storage::url($data->file_lampiran) }}"
                   class="btn-primary" target="_blank">
                    <i class="fa-solid fa-download"></i> Unduh Kalender Akademik
                </a>
            </div>
            @endif
            @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-slate-50 p-8 md:p-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white text-2xl"
                     style="color:var(--color-primary)">
                    <i class="fa-regular fa-calendar"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700">Belum ada kalender akademik</h3>
                <p class="mt-2 text-sm text-gray-500">Informasi kalender akademik akan tampil di sini setelah ditambahkan.</p>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
