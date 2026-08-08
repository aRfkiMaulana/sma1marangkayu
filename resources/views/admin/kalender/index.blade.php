@extends('admin.layouts.app')
@section('title', 'Kalender Akademik')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-800">Kalender Akademik</h1>
    <p class="text-sm text-gray-500">Upload gambar/poster Kalender Akademik tahun ajaran berjalan.</p>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form action="{{ route('admin.kalender.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Upload Gambar Kalender (JPG/PNG)</label>
                <input type="file" name="foto" class="form-input" accept="image/*" required>
                <p class="text-xs text-gray-400 mt-1">Gambar akan otomatis dikonversi ke WebP untuk menghemat ukuran. Maks: 5MB.</p>
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                <i class="fa-solid fa-cloud-arrow-up text-xs"></i> Upload & Simpan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-sm font-bold text-gray-800 mb-4">Preview Kalender Aktif</h2>
        @if($kalender && $kalender->file_lampiran)
            <img src="{{ Storage::url($kalender->file_lampiran) }}" alt="Kalender Akademik" class="w-full rounded-xl border border-slate-200">
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-slate-50 p-8 text-center text-gray-400">
                <i class="fa-regular fa-image text-4xl mb-2"></i>
                <p class="text-sm">Belum ada gambar kalender akademik</p>
            </div>
        @endif
    </div>
</div>
@endsection
