@extends('admin.layouts.app')
@section('title', 'Profil Sekolah')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-500">Nama Sekolah <span class="text-danger">*</span></label>
                    <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah', $profil->nama_sekolah) }}" required>
                </div>
                <div class="col-md-2"><label class="form-label fw-500">NPSN</label><input type="text" name="npsn" class="form-control" value="{{ old('npsn', $profil->npsn) }}"></div>
                <div class="col-md-2"><label class="form-label fw-500">Akreditasi</label><input type="text" name="akreditasi" class="form-control" value="{{ old('akreditasi', $profil->akreditasi) }}"></div>
                <div class="col-md-6"><label class="form-label fw-500">Kepala Sekolah</label><input type="text" name="kepala_sekolah" class="form-control" value="{{ old('kepala_sekolah', $profil->kepala_sekolah) }}"></div>
                <div class="col-md-3"><label class="form-label fw-500">Tahun Berdiri</label><input type="number" name="tahun_berdiri" class="form-control" value="{{ old('tahun_berdiri', $profil->tahun_berdiri) }}"></div>
                <div class="col-md-3"><label class="form-label fw-500">Telepon</label><input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}"></div>

                <div class="col-12"><label class="form-label fw-500">Alamat</label><input type="text" name="alamat" class="form-control" value="{{ old('alamat', $profil->alamat) }}"></div>
                <div class="col-md-3"><label class="form-label fw-500">Kecamatan</label><input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $profil->kecamatan) }}"></div>
                <div class="col-md-3"><label class="form-label fw-500">Kabupaten</label><input type="text" name="kabupaten" class="form-control" value="{{ old('kabupaten', $profil->kabupaten) }}"></div>
                <div class="col-md-3"><label class="form-label fw-500">Provinsi</label><input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $profil->provinsi) }}"></div>
                <div class="col-md-3"><label class="form-label fw-500">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $profil->email) }}"></div>

                <div class="col-md-4"><label class="form-label fw-500">WhatsApp</label><input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $profil->whatsapp) }}"></div>
                <div class="col-md-4"><label class="form-label fw-500">Instagram</label><input type="text" name="instagram" class="form-control" value="{{ old('instagram', $profil->instagram) }}"></div>
                <div class="col-md-4"><label class="form-label fw-500">YouTube</label><input type="text" name="youtube" class="form-control" value="{{ old('youtube', $profil->youtube) }}"></div>

                <div class="col-md-4">
                    <label class="form-label fw-500">Jumlah Siswa</label>
                    <input type="number" name="jumlah_siswa" class="form-control" value="{{ old('jumlah_siswa', $profil->jumlah_siswa) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Jumlah Guru</label>
                    <input type="number" name="jumlah_guru" class="form-control" value="{{ old('jumlah_guru', $profil->jumlah_guru) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-500">Jumlah Staf</label>
                    <input type="number" name="jumlah_staf" class="form-control" value="{{ old('jumlah_staf', $profil->jumlah_staf) }}">
                </div>

                <div class="col-12"><label class="form-label fw-500">Visi</label><textarea name="visi" class="form-control" rows="3">{{ old('visi', $profil->visi) }}</textarea></div>
                <div class="col-12"><label class="form-label fw-500">Misi</label><textarea name="misi" class="form-control" rows="6">{{ old('misi', $profil->misi) }}</textarea></div>
                <div class="col-12"><label class="form-label fw-500">Sejarah</label><textarea name="sejarah" class="form-control" rows="6">{{ old('sejarah', $profil->sejarah) }}</textarea></div>
                <div class="col-12"><label class="form-label fw-500">Embed Google Maps</label><textarea name="maps_embed" class="form-control" rows="3">{{ old('maps_embed', $profil->maps_embed) }}</textarea></div>

                <div class="col-md-6">
                    <label class="form-label fw-500">Logo</label>
                    @if($profil->logo)<div class="mb-2"><img src="{{ Storage::url($profil->logo) }}" height="50" alt="Logo"></div>@endif
                    <input type="file" name="logo" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-500">Foto Sekolah</label>
                    @if($profil->foto_sekolah)<div class="mb-2"><img src="{{ Storage::url($profil->foto_sekolah) }}" height="60" class="rounded" alt="Foto"></div>@endif
                    <input type="file" name="foto_sekolah" class="form-control" accept="image/*">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
