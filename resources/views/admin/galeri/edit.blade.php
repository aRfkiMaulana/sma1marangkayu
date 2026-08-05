@extends('admin.layouts.app')
@section('title', 'Edit Galeri')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.galeri.update', $galeri) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-input" value="{{ old('judul', $galeri->judul) }}" required>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-input">
                            <option value="foto" {{ $galeri->tipe === 'foto' ? 'selected':'' }}>Foto</option>
                            <option value="video" {{ $galeri->tipe === 'video' ? 'selected':'' }}>Video</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Album</label>
                        <input type="text" name="album" class="form-input" value="{{ old('album', $galeri->album) }}">
                    </div>
                </div>

                @if($galeri->tipe === 'foto')
                <div>
                    <label class="form-label">Ganti Foto</label>
                    <img src="{{ Storage::url($galeri->file) }}" class="h-24 rounded-xl object-cover mb-2" alt="">
                    <input type="file" name="file" class="form-input" accept="image/*">
                </div>
                @else
                <div>
                    <label class="form-label">URL Video</label>
                    <input type="url" name="link" class="form-input" value="{{ old('link', $galeri->file) }}">
                </div>
                @endif

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', $galeri->urutan) }}">
                    </div>
                    <div class="flex items-end pb-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_highlight" value="1"
                                   {{ $galeri->is_highlight ? 'checked':'' }}
                                   class="w-4 h-4 rounded accent-blue-800">
                            <span class="text-sm text-gray-700">Jadikan Highlight</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui</button>
                    <a href="{{ route('admin.galeri.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
