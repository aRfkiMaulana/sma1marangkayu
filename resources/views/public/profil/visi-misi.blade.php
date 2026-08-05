@extends('layouts.public')
@section('title', 'Visi & Misi - SMA Negeri 1 Marangkayu')

@section('content')
<div class="bg-slate-50 border-b border-slate-200 py-3">
    <div class="container mx-auto max-w-7xl px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Visi &amp; Misi</span>
        </nav>
    </div>
</div>

<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="text-center mb-12">
            <h1 class="section-title mx-auto after:mx-auto">Visi &amp; Misi</h1>
            <p class="text-gray-500 mt-3">SMA Negeri 1 Marangkayu</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            {{-- VISI --}}
            <div class="rounded-2xl p-8 text-white flex flex-col"
                 style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light))">
                <div class="w-14 h-14 rounded-2xl mb-5 flex items-center justify-center text-2xl"
                     style="background-color: rgba(255,255,255,0.15)">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h2 class="text-xl font-bold tracking-wide mb-4" style="color: var(--color-accent)">VISI</h2>
                <p class="text-white/85 leading-relaxed">{{ $profil->visi ?? 'Belum diisi.' }}</p>
            </div>

            {{-- MISI --}}
            <div class="rounded-2xl p-8 bg-white shadow-sm border border-slate-100 flex flex-col">
                <div class="w-14 h-14 rounded-2xl mb-5 flex items-center justify-center text-2xl"
                     style="background-color: #dbeafe; color: var(--color-primary)">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <h2 class="text-xl font-bold tracking-wide mb-4" style="color: var(--color-primary)">MISI</h2>
                <div class="text-gray-600 leading-relaxed text-sm whitespace-pre-line">{{ $profil->misi ?? 'Belum diisi.' }}</div>
            </div>
        </div>

        {{-- TUJUAN --}}
        @if($profil && $profil->tujuan)
        <div class="rounded-2xl p-8 bg-white shadow-sm border border-slate-100">
            <div class="flex items-center gap-4 mb-5">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0"
                     style="background-color: #fef3c7; color: var(--color-accent)">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h2 class="text-xl font-bold" style="color: var(--color-primary)">TUJUAN</h2>
            </div>
            <div class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $profil->tujuan }}</div>
        </div>
        @endif
    </div>
</section>
@endsection
