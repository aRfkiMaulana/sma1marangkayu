@extends('admin.layouts.app')
@section('title', 'Tambah Fasilitas')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form method="POST" action="{{ route('admin.fasilitas.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label fw-500">Nama Fasilitas <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required></div>
            <div class="col-md-4"><label class="form-label fw-500">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" placeholder="Kelas, Lab, Olahraga..."></div>
            <div class="col-md-3"><label class="form-label fw-500">Jumlah</label><input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 1) }}" min="1"></div>
            <div class="col-md-2"><label class="form-label fw-500">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}"></div>
            <div class="col-12"><label class="form-label fw-500">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea></div>
            <div class="col-md-6"><label class="form-label fw-500">Foto</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
