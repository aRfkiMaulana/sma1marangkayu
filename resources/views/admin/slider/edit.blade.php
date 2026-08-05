@extends('admin.layouts.app')
@section('title', 'Edit Slider')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.slider.update', $slider) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-input" value="{{ old('judul', $slider->judul) }}">
                </div>
                <div>
                    <label class="form-label">Subjudul</label>
                    <input type="text" name="subjudul" class="form-input" value="{{ old('subjudul', $slider->subjudul) }}">
                </div>
                <div>
                    <label class="form-label">Ganti Gambar</label>
                    <img src="{{ Storage::url($slider->gambar) }}"
                         class="w-full h-36 rounded-xl object-cover mb-2"
                         onerror="this.style.display='none'" alt="">
                    <input type="file" name="gambar" class="form-input" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Link</label>
                        <input type="url" name="link" class="form-input" value="{{ old('link', $slider->link) }}">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', $slider->urutan) }}">
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1"
                               {{ $slider->is_aktif ? 'checked':'' }}
                               class="w-4 h-4 rounded accent-blue-800">
                        <span class="text-sm text-gray-700">Aktifkan slider ini</span>
                    </label>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui</button>
                    <a href="{{ route('admin.slider.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
