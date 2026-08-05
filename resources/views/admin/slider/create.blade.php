@extends('admin.layouts.app')
@section('title', 'Tambah Slider')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.slider.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Judul (opsional)</label>
                    <input type="text" name="judul" class="form-input" value="{{ old('judul') }}"
                           placeholder="Misal: Selamat Datang di SMAN 1 Marangkayu">
                </div>
                <div>
                    <label class="form-label">Subjudul (opsional)</label>
                    <input type="text" name="subjudul" class="form-input" value="{{ old('subjudul') }}"
                           placeholder="Tagline atau keterangan singkat">
                </div>
                <div>
                    <label class="form-label">Gambar <span class="text-red-500">*</span></label>
                    <input type="file" name="gambar" class="form-input" accept="image/*" required>
                    <p class="text-xs text-gray-400 mt-1">Ukuran ideal 1400×520px. Maks 4MB.</p>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Link (opsional)</label>
                        <input type="url" name="link" class="form-input" value="{{ old('link') }}" placeholder="https://...">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', 1) }}">
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1" checked class="w-4 h-4 rounded accent-blue-800">
                        <span class="text-sm text-gray-700">Aktifkan slider ini</span>
                    </label>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    <a href="{{ route('admin.slider.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
