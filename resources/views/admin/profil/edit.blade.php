@extends('admin.layouts.app')
@section('title', 'Profil Sekolah')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-6">

                {{-- INFO DASAR --}}
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Informasi Dasar</h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="sm:col-span-2">
                            <label class="form-label">Nama Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_sekolah" class="form-input" value="{{ old('nama_sekolah', $profil->nama_sekolah) }}" required>
                        </div>
                        <div><label class="form-label">NPSN</label><input type="text" name="npsn" class="form-input" value="{{ old('npsn', $profil->npsn) }}"></div>
                        <div><label class="form-label">Akreditasi</label><input type="text" name="akreditasi" class="form-input" value="{{ old('akreditasi', $profil->akreditasi) }}"></div>
                        <div class="sm:col-span-2"><label class="form-label">Kepala Sekolah</label><input type="text" name="kepala_sekolah" class="form-input" value="{{ old('kepala_sekolah', $profil->kepala_sekolah) }}"></div>
                        <div><label class="form-label">Tahun Berdiri</label><input type="number" name="tahun_berdiri" class="form-input" value="{{ old('tahun_berdiri', $profil->tahun_berdiri) }}"></div>
                        <div><label class="form-label">Telepon</label><input type="text" name="telepon" class="form-input" value="{{ old('telepon', $profil->telepon) }}"></div>
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- ALAMAT --}}
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Alamat</h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="sm:col-span-4"><label class="form-label">Alamat Lengkap</label><input type="text" name="alamat" class="form-input" value="{{ old('alamat', $profil->alamat) }}"></div>
                        <div><label class="form-label">Kecamatan</label><input type="text" name="kecamatan" class="form-input" value="{{ old('kecamatan', $profil->kecamatan) }}"></div>
                        <div><label class="form-label">Kabupaten</label><input type="text" name="kabupaten" class="form-input" value="{{ old('kabupaten', $profil->kabupaten) }}"></div>
                        <div><label class="form-label">Provinsi</label><input type="text" name="provinsi" class="form-input" value="{{ old('provinsi', $profil->provinsi) }}"></div>
                        <div><label class="form-label">Kode Pos</label><input type="text" name="kode_pos" class="form-input" value="{{ old('kode_pos', $profil->kode_pos) }}"></div>
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- KONTAK & SOSMED --}}
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Kontak &amp; Media Sosial</h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div><label class="form-label">Email</label><input type="email" name="email" class="form-input" value="{{ old('email', $profil->email) }}"></div>
                        <div><label class="form-label">WhatsApp</label><input type="text" name="whatsapp" class="form-input" value="{{ old('whatsapp', $profil->whatsapp) }}"></div>
                        <div><label class="form-label">Website</label><input type="url" name="website" class="form-input" value="{{ old('website', $profil->website) }}"></div>
                        <div><label class="form-label">Facebook</label><input type="text" name="facebook" class="form-input" value="{{ old('facebook', $profil->facebook) }}"></div>
                        <div><label class="form-label">Instagram</label><input type="text" name="instagram" class="form-input" value="{{ old('instagram', $profil->instagram) }}"></div>
                        <div><label class="form-label">YouTube</label><input type="text" name="youtube" class="form-input" value="{{ old('youtube', $profil->youtube) }}"></div>
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- STATISTIK --}}
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Statistik</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div><label class="form-label">Jumlah Siswa</label><input type="number" name="jumlah_siswa" class="form-input" value="{{ old('jumlah_siswa', $profil->jumlah_siswa) }}"></div>
                        <div><label class="form-label">Jumlah Guru</label><input type="number" name="jumlah_guru" class="form-input" value="{{ old('jumlah_guru', $profil->jumlah_guru) }}"></div>
                        <div><label class="form-label">Jumlah Staf</label><input type="number" name="jumlah_staf" class="form-input" value="{{ old('jumlah_staf', $profil->jumlah_staf) }}"></div>
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- KONTEN --}}
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Konten Profil</h3>
                    <div class="grid gap-4">
                        <div><label class="form-label">Visi</label><textarea name="visi" class="form-input" rows="3">{{ old('visi', $profil->visi) }}</textarea></div>
                        <div><label class="form-label">Misi</label><textarea name="misi" class="form-input" rows="6">{{ old('misi', $profil->misi) }}</textarea></div>
                        <div><label class="form-label">Sejarah</label><textarea name="sejarah" class="form-input" rows="6">{{ old('sejarah', $profil->sejarah) }}</textarea></div>
                        <div><label class="form-label">Embed Google Maps</label><textarea name="maps_embed" class="form-input" rows="3" placeholder='&lt;iframe src="..." ...&gt;&lt;/iframe&gt;'>{{ old('maps_embed', $profil->maps_embed) }}</textarea></div>
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- MEDIA --}}
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wide text-gray-400 mb-4">Logo &amp; Foto</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Logo Sekolah</label>
                            @if($profil->logo)<img src="{{ Storage::url($profil->logo) }}" class="h-14 mb-2 object-contain" alt="Logo">@endif
                            <input type="file" name="logo" class="form-input" accept="image/*">
                        </div>
                        <div>
                            <label class="form-label">Foto Kepala Sekolah</label>
                            @if($profil->foto_sekolah)<img src="{{ Storage::url($profil->foto_sekolah) }}" class="h-16 rounded-lg mb-2 object-cover" alt="Foto Kepala Sekolah">@endif
                            <input type="file" name="foto_sekolah" class="form-input" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
