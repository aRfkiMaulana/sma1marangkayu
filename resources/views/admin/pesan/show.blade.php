@extends('admin.layouts.app')
@section('title', 'Detail Pesan')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3"
             style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light))">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white"
                 style="background-color: rgba(255,255,255,0.15)">
                <i class="fa-solid fa-envelope-open"></i>
            </div>
            <div>
                <p class="font-semibold text-white">{{ $pesan->subjek }}</p>
                <p class="text-xs text-white/70">{{ $pesan->created_at->translatedFormat('d F Y, H:i') }}</p>
            </div>
        </div>

        {{-- Info Pengirim --}}
        <div class="grid sm:grid-cols-3 gap-0 divide-y sm:divide-y-0 sm:divide-x divide-slate-100 border-b border-slate-100">
            <div class="px-5 py-4">
                <p class="text-xs text-gray-400 mb-1">Nama</p>
                <p class="font-medium text-gray-800">{{ $pesan->nama }}</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-xs text-gray-400 mb-1">Email</p>
                <a href="mailto:{{ $pesan->email }}" class="font-medium text-blue-700 hover:underline">{{ $pesan->email }}</a>
            </div>
            <div class="px-5 py-4">
                <p class="text-xs text-gray-400 mb-1">Telepon</p>
                <p class="font-medium text-gray-800">{{ $pesan->telepon ?? '-' }}</p>
            </div>
        </div>

        {{-- Isi Pesan --}}
        <div class="px-6 py-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Isi Pesan</p>
            <div class="bg-slate-50 rounded-xl p-4 text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                {{ $pesan->pesan }}
            </div>
        </div>

        {{-- Aksi --}}
        <div class="px-6 py-4 border-t border-slate-100 flex flex-wrap gap-3">
            <a href="mailto:{{ $pesan->email }}?subject=Re: {{ $pesan->subjek }}"
               class="btn-primary">
                <i class="fa-solid fa-reply"></i> Balas via Email
            </a>
            <a href="{{ route('admin.pesan.index') }}" class="btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <form method="POST" action="{{ route('admin.pesan.destroy', $pesan) }}"
                  class="ml-auto" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf @method('DELETE')
                <button class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium border border-red-200 text-red-600 hover:bg-red-50 transition-colors">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
