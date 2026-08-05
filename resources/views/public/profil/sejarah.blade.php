@extends('layouts.public')
@section('title', 'Sejarah Sekolah - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Profil</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Sejarah Sekolah</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-4xl px-4">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="section-title mx-auto after:mx-auto">Sejarah Sekolah</h1>
            <p class="text-gray-500 mt-3">SMA Negeri 1 Marangkayu, Kutai Kartanegara</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 md:p-12">
            @if($profil && $profil->sejarah)
            <div class="prose prose-blue max-w-none text-gray-700 leading-relaxed text-base">
                {!! nl2br(e($profil->sejarah)) !!}
            </div>
            @else
            <div class="text-center py-16">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-book-open text-2xl text-slate-400"></i>
                </div>
                <p class="text-gray-400">Informasi sejarah sekolah belum tersedia.</p>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
