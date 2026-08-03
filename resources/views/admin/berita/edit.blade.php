@extends('admin.layouts.app')
@section('title', 'Edit Berita')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.berita.update', $berita) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-500">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $berita->judul) }}" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Tipe</label>
                    <select name="tipe" class="form-select">
                        @foreach(['berita','pengumuman','agenda'] as $t)
                        <option value="{{ $t }}" {{ old('tipe', $berita->tipe) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id', $berita->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status', $berita->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $berita->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-500">Ringkasan</label>
                    <textarea name="ringkasan" class="form-control" rows="2">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-500">Konten <span class="text-danger">*</span></label>
                    <textarea name="konten" class="form-control" rows="12">{{ old('konten', $berita->konten) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-500">Thumbnail</label>
                    @if($berita->thumbnail)
                    <div class="mb-2"><img src="{{ Storage::url($berita->thumbnail) }}" height="80" class="rounded" alt="thumb"></div>
                    @endif
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-500">Tanggal Publish</label>
                    <input type="datetime-local" name="tanggal_publish" class="form-control"
                           value="{{ old('tanggal_publish', $berita->tanggal_publish ? $berita->tanggal_publish->format('Y-m-d\TH:i') : '') }}">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Perbarui</button>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
