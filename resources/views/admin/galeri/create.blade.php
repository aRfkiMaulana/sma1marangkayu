@extends('admin.layouts.app')
@section('title', 'Tambah Galeri')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data"
              x-data="{ tipe: 'foto' }">
            @csrf
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" class="form-input" value="{{ old('judul') }}" required>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-input" x-model="tipe">
                            <option value="foto">Foto</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Album</label>
                        <input type="text" name="album" class="form-input" value="{{ old('album') }}" placeholder="Nama album">
                    </div>
                </div>

                <div x-show="tipe === 'foto'">
                    <label class="form-label">Upload Foto <span class="text-red-500">*</span></label>
                    <input type="file" name="file" class="form-input" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Maks 4MB</p>
                </div>
                <div x-show="tipe === 'video'" style="display:none">
                    <label class="form-label">URL Video (YouTube)</label>
                    <input type="url" name="link" class="form-input" placeholder="https://youtube.com/...">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', 0) }}">
                    </div>
                    <div class="flex items-end pb-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_highlight" value="1" {{ old('is_highlight') ? 'checked':'' }}
                                   class="w-4 h-4 rounded accent-blue-800">
                            <span class="text-sm text-gray-700">Jadikan Highlight (tampil di beranda)</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    <a href="{{ route('admin.galeri.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
