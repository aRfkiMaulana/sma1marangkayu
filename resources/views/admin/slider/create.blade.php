@extends('admin.layouts.app')
@section('title', 'Tambah Slider')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form method="POST" action="{{ route('admin.slider.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label fw-500">Judul (opsional)</label><input type="text" name="judul" class="form-control" value="{{ old('judul') }}"></div>
            <div class="col-md-6"><label class="form-label fw-500">Subjudul (opsional)</label><input type="text" name="subjudul" class="form-control" value="{{ old('subjudul') }}"></div>
            <div class="col-md-8"><label class="form-label fw-500">Gambar <span class="text-danger">*</span></label>
                <input type="file" name="gambar" class="form-control" accept="image/*" required>
                <div class="form-text">Ukuran ideal: 1400×520px. Maks 4MB.</div></div>
            <div class="col-md-2"><label class="form-label fw-500">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ old('urutan', 1) }}"></div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="is_aktif" value="1" checked>
                <label class="form-check-label">Aktif</label></div>
            </div>
            <div class="col-md-6"><label class="form-label fw-500">Link (opsional)</label><input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://..."></div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.slider.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
