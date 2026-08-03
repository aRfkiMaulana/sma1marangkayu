@extends('admin.layouts.app')
@section('title', 'Edit Slider')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form method="POST" action="{{ route('admin.slider.update', $slider) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label fw-500">Judul</label><input type="text" name="judul" class="form-control" value="{{ old('judul', $slider->judul) }}"></div>
            <div class="col-md-6"><label class="form-label fw-500">Subjudul</label><input type="text" name="subjudul" class="form-control" value="{{ old('subjudul', $slider->subjudul) }}"></div>
            <div class="col-md-8">
                <div class="mb-2"><img src="{{ Storage::url($slider->gambar) }}" height="70" class="rounded" alt="" onerror="this.style.display='none'"></div>
                <label class="form-label fw-500">Ganti Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>
            <div class="col-md-2"><label class="form-label fw-500">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ old('urutan', $slider->urutan) }}"></div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="is_aktif" value="1" {{ $slider->is_aktif ? 'checked' : '' }}>
                <label class="form-check-label">Aktif</label></div>
            </div>
            <div class="col-md-6"><label class="form-label fw-500">Link</label><input type="url" name="link" class="form-control" value="{{ old('link', $slider->link) }}"></div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Perbarui</button>
                <a href="{{ route('admin.slider.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
