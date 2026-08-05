@extends('layouts.public')
@section('title', 'Program Studi - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Program Studi</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-4xl px-4">
        <div class="text-center mb-10">
            <h1 class="section-title mx-auto after:mx-auto">Program Studi / Jurusan</h1>
        </div>
        @forelse($data as $d)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-4">
            <h2 class="font-bold text-lg mb-4" style="color: var(--color-primary)">{{ $d->judul }}</h2>
            <div class="prose prose-blue max-w-none text-gray-700">{!! $d->konten !!}</div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center text-gray-400">
            <i class="fa-solid fa-graduation-cap text-4xl mb-3 block text-slate-300"></i>
            Informasi program studi belum tersedia.
        </div>
        @endforelse
    </div>
</section>
@endsection
