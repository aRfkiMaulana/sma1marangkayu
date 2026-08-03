@extends('admin.layouts.app')
@section('title', 'Tambah Guru / Staf')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form method="POST" action="{{ route('admin.guru-staf.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label fw-500">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required></div>
            <div class="col-md-4"><label class="form-label fw-500">Tipe <span class="text-danger">*</span></label>
                <select name="tipe" class="form-select">
                    <option value="guru">Guru</option><option value="staf">Staf</option>
                </select></div>
            <div class="col-md-4"><label class="form-label fw-500">NIP</label><input type="text" name="nip" class="form-control" value="{{ old('nip') }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Jabatan</label><input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Mata Pelajaran</label><input type="text" name="mata_pelajaran" class="form-control" value="{{ old('mata_pelajaran') }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Pendidikan Terakhir</label><input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir') }}" placeholder="S1, S2, dll."></div>
            <div class="col-md-4"><label class="form-label fw-500">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}"></div>
            <div class="col-md-4">
                <label class="form-label fw-500">Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <div class="form-text">Maks 2MB</div>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                <a href="{{ route('admin.guru-staf.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
