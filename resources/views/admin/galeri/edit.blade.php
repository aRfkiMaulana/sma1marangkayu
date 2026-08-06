@extends('admin.layouts.app')
@section('title', 'Edit Foto Galeri')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.galeri.update', $galeri) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-5">

                <div>
                    <label class="form-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" class="form-input @error('judul') border-red-400 @enderror"
                           value="{{ old('judul', $galeri->judul) }}" required>
                    @error('judul')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label">Ganti Foto</label>
                    @if($galeri->file)
                    <img src="{{ Storage::url($galeri->file) }}"
                         class="h-32 rounded-xl object-cover mb-2" alt="{{ $galeri->judul }}">
                    @endif
                    <input type="file" name="file" class="form-input @error('file') border-red-400 @enderror"
                           accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti. Maks 4MB.</p>
                    @error('file')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Album</label>
                        <input type="text" name="album" class="form-input"
                               value="{{ old('album', $galeri->album) }}" placeholder="Nama album (opsional)">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input"
                               value="{{ old('urutan', $galeri->urutan) }}">
                    </div>
                </div>

                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-input">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_highlight" value="1"
                               {{ $galeri->is_highlight ? 'checked' : '' }} class="w-4 h-4 rounded">
                        <span class="text-sm text-gray-700">Jadikan Highlight (tampil di beranda)</span>
                    </label>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui
                    </button>
                    <a href="{{ route('admin.galeri.index') }}" class="btn-outline">Batal</a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
