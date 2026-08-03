@extends('admin.layouts.app')
@section('title', 'Edit Guru / Staf')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form method="POST" action="{{ route('admin.guru-staf.update', $guruStaf) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-8"><label class="form-label fw-500">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $guruStaf->nama) }}" required></div>
            <div class="col-md-4"><label class="form-label fw-500">Tipe</label>
                <select name="tipe" class="form-select">
                    <option value="guru" {{ $guruStaf->tipe === 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="staf" {{ $guruStaf->tipe === 'staf' ? 'selected' : '' }}>Staf</option>
                </select></div>
            <div class="col-md-4"><label class="form-label fw-500">NIP</label><input type="text" name="nip" class="form-control" value="{{ old('nip', $guruStaf->nip) }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Jabatan</label><input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $guruStaf->jabatan) }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Mata Pelajaran</label><input type="text" name="mata_pelajaran" class="form-control" value="{{ old('mata_pelajaran', $guruStaf->mata_pelajaran) }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Pendidikan Terakhir</label><input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir', $guruStaf->pendidikan_terakhir) }}"></div>
            <div class="col-md-4"><label class="form-label fw-500">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $guruStaf->email) }}"></div>
            <div class="col-md-2"><label class="form-label fw-500">Urutan</label><input type="number" name="urutan" class="form-control" value="{{ old('urutan', $guruStaf->urutan) }}"></div>
            <div class="col-md-2">
                <label class="form-label fw-500">Status</label><br>
                <div class="form-check form-switch mt-1">
                    <input class="form-check-input" type="checkbox" name="is_aktif" value="1" {{ $guruStaf->is_aktif ? 'checked' : '' }}>
                    <label class="form-check-label small">Aktif</label>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-500">Foto</label>
                @if($guruStaf->foto)<div class="mb-2"><img src="{{ Storage::url($guruStaf->foto) }}" height="60" class="rounded-circle" alt=""></div>@endif
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Perbarui</button>
                <a href="{{ route('admin.guru-staf.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </form>
</div></div>
@endsection
