@extends('admin.layouts.app')
@section('title', 'Pengaturan Bobot Poin Prestasi')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Pengaturan Bobot Poin Prestasi</h1>
        <p class="text-sm text-gray-500">Atur besaran poin untuk kalkulasi peringkat ekstrakurikuler berdasarkan tingkat kejuaraan</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-2xl">
    <form action="{{ route('admin.setting-bobot.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        @foreach($bobotList as $b)
        <div class="flex items-center justify-between gap-4 p-3 rounded-xl bg-slate-50 border border-slate-100">
            <div>
                <span class="font-bold text-gray-800 capitalize text-sm">{{ $b->tingkat }}</span>
                <p class="text-xs text-gray-500">Bobot poin untuk kejuaraan tingkat {{ $b->tingkat }}</p>
            </div>
            <div class="w-32 flex items-center gap-2">
                <input type="number" name="bobot[{{ $b->tingkat }}]" class="form-input text-right font-bold" value="{{ old('bobot.' . $b->tingkat, $b->bobot) }}" min="0" max="1000" required>
                <span class="text-xs font-semibold text-gray-500">Poin</span>
            </div>
        </div>
        @endforeach

        <div class="pt-4 flex justify-end">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Bobot Poin
            </button>
        </div>
    </form>
</div>
@endsection
