@extends('admin.layouts.app')
@section('title', 'Tambah Berita')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-500">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Tipe</label>
                    <select name="tipe" class="form-select">
                        <option value="berita" {{ old('tipe') === 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="pengumuman" {{ old('tipe') === 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="agenda" {{ old('tipe') === 'agenda' ? 'selected' : '' }}>Agenda</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status','draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-500">Ringkasan</label>
                    <textarea name="ringkasan" class="form-control" rows="2" placeholder="Ringkasan singkat berita (opsional)">{{ old('ringkasan') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-500">Konten <span class="text-danger">*</span></label>
                    <textarea name="konten" id="konten" class="form-control @error('konten') is-invalid @enderror" rows="12">{{ old('konten') }}</textarea>
                    @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-500">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    <div class="form-text">Format: jpg, png, webp. Maks 2MB.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-500">Tanggal Publish</label>
                    <input type="datetime-local" name="tanggal_publish" class="form-control" value="{{ old('tanggal_publish') }}">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
