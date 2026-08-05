@extends('admin.layouts.app')
@section('title', 'Edit Fasilitas')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.fasilitas.update', $fasilitas) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Nama Fasilitas</label>
                    <input type="text" name="nama" class="form-input" value="{{ old('nama', $fasilitas->nama) }}" required>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-input" value="{{ old('kategori', $fasilitas->kategori) }}">
                    </div>
                    <div>
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-input" value="{{ old('jumlah', $fasilitas->jumlah) }}" min="1">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', $fasilitas->urutan) }}">
                    </div>
                </div>
                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-input" rows="3">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                </div>
                <div>
                    <label class="form-label">Foto</label>
                    @if($fasilitas->foto)
                    <img src="{{ Storage::url($fasilitas->foto) }}" class="h-20 rounded-xl object-cover mb-2" alt="">
                    @endif
                    <input type="file" name="foto" class="form-input" accept="image/*">
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1"
                               {{ $fasilitas->is_aktif ? 'checked':'' }}
                               class="w-4 h-4 rounded accent-blue-800">
                        <span class="text-sm text-gray-700">Tampilkan di website</span>
                    </label>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui</button>
                    <a href="{{ route('admin.fasilitas.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
