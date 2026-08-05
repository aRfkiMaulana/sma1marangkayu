@extends('layouts.public')
@section('title', 'Kalender Akademik - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Kalender Akademik</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-4xl px-4">
        <div class="text-center mb-10">
            <h1 class="section-title mx-auto after:mx-auto">Kalender Akademik</h1>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
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
            <div class="text-center py-12 text-gray-400">
                <i class="fa-regular fa-calendar text-4xl mb-3 block text-slate-300"></i>
                Kalender akademik belum tersedia.
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
