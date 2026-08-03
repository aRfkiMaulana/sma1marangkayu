@extends('admin.layouts.app')
@section('title', 'Edit Galeri')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form method="POST" action="{{ route('admin.galeri.update', $galeri) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label fw-500">Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $galeri->judul) }}" required></div>
            <div class="col-md-4"><label class="form-label fw-500">Tipe</label>
                <select name="tipe" class="form-select">
                    <option value="foto" {{ $galeri->tipe === 'foto' ? 'selected' : '' }}>Foto</option>
                    <option value="video" {{ $galeri->tipe === 'video' ? 'selected' : '' }}>Video</option>
                </select></div>
            @if($galeri->tipe === 'foto')
            <div class="col-md-6">
                <div class="mb-2"><img src="{{ Storage::url($galeri->file) }}" height="60" class="rounded" alt=""></div>
                <label class="form-label fw-500">Ganti Foto</label>
                <input type="file" name="file" class="form-control" accept="image/*">
            </div>
            @else
            <div class="col-md-6"><label class="form-label fw-500">URL Video</label>
                <input type="url" name="link" class="form-control" value="{{ old('link', $galeri->file) }}"></div>
            @endif
            <div class="col-md-4"><label class="form-label fw-500">Album</label>
                <input type="text" name="album" class="form-control" value="{{ old('album', $galeri->album) }}"></div>
            <div class="col-md-2"><label class="form-label fw-500">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $galeri->urutan) }}"></div>
            <div class="col-12">
                <div class="form-check"><input class="form-check-input" type="checkbox" name="is_highlight" value="1" {{ $galeri->is_highlight ? 'checked' : '' }}>
                <label class="form-check-label">Jadikan Highlight</label></div>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Perbarui</button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
