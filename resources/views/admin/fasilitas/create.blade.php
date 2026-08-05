@extends('admin.layouts.app')
@section('title', 'Tambah Fasilitas')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.fasilitas.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Nama Fasilitas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" class="form-input" value="{{ old('nama') }}" required>
                </div>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-input"
                               value="{{ old('kategori') }}" placeholder="Kelas, Lab, Olahraga…">
                    </div>
                    <div>
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-input" value="{{ old('jumlah', 1) }}" min="1">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', 0) }}">
                    </div>
                </div>
                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-input" rows="3">{{ old('deskripsi') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-input" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Maks 4MB</p>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    <a href="{{ route('admin.fasilitas.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
