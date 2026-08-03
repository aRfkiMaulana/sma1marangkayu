@extends('admin.layouts.app')
@section('title', 'Tambah Galeri')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label fw-500">Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required></div>
            <div class="col-md-4"><label class="form-label fw-500">Tipe</label>
                <select name="tipe" id="tipe" class="form-select" onchange="toggleField()">
                    <option value="foto">Foto</option><option value="video">Video</option>
                </select></div>
            <div id="field-foto" class="col-md-6"><label class="form-label fw-500">Upload Foto</label>
                <input type="file" name="file" class="form-control" accept="image/*"></div>
            <div id="field-video" class="col-md-6 d-none"><label class="form-label fw-500">URL Video (YouTube)</label>
                <input type="url" name="link" class="form-control" placeholder="https://youtube.com/..."></div>
            <div class="col-md-4"><label class="form-label fw-500">Album</label>
                <input type="text" name="album" class="form-control" value="{{ old('album') }}" placeholder="Nama album"></div>
            <div class="col-md-2"><label class="form-label fw-500">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}"></div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="is_highlight" id="highlight" value="1" {{ old('is_highlight') ? 'checked' : '' }}>
                <label class="form-check-label" for="highlight">Highlight</label></div>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@push('scripts')
<script>
function toggleField(){
    const t = document.getElementById('tipe').value;
    document.getElementById('field-foto').classList.toggle('d-none', t !== 'foto');
    document.getElementById('field-video').classList.toggle('d-none', t !== 'video');
}
</script>
@endpush
@endsection
