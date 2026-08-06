@extends('admin.layouts.app')
@section('title', 'Tambah Prestasi')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.prestasi.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-5">

                <div>
                    <label class="form-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" class="form-input @error('judul') border-red-400 @enderror"
                           value="{{ old('judul') }}" required>
                    @error('judul')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Peraih</label>
                    <input type="text" name="peraih" class="form-input @error('peraih') border-red-400 @enderror"
                           value="{{ old('peraih') }}" placeholder="Nama siswa atau tim">
                    @error('peraih')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Tingkat <span class="text-red-500">*</span></label>
                        <select name="tingkat" class="form-input @error('tingkat') border-red-400 @enderror" required>
                            <option value="">— Pilih Tingkat —</option>
                            <option value="sekolah"       {{ old('tingkat') === 'sekolah'       ? 'selected' : '' }}>Sekolah</option>
                            <option value="kecamatan"     {{ old('tingkat') === 'kecamatan'     ? 'selected' : '' }}>Kecamatan</option>
                            <option value="kabupaten"     {{ old('tingkat') === 'kabupaten'     ? 'selected' : '' }}>Kabupaten</option>
                            <option value="provinsi"      {{ old('tingkat') === 'provinsi'      ? 'selected' : '' }}>Provinsi</option>
                            <option value="nasional"      {{ old('tingkat') === 'nasional'      ? 'selected' : '' }}>Nasional</option>
                            <option value="internasional" {{ old('tingkat') === 'internasional' ? 'selected' : '' }}>Internasional</option>
                        </select>
                        @error('tingkat')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" class="form-input @error('kategori') border-red-400 @enderror" required>
                            <option value="">— Pilih Kategori —</option>
                            <option value="akademik"     {{ old('kategori') === 'akademik'     ? 'selected' : '' }}>Akademik</option>
                            <option value="non_akademik" {{ old('kategori') === 'non_akademik' ? 'selected' : '' }}>Non Akademik</option>
                            <option value="olahraga"     {{ old('kategori') === 'olahraga'     ? 'selected' : '' }}>Olahraga</option>
                            <option value="seni"         {{ old('kategori') === 'seni'         ? 'selected' : '' }}>Seni</option>
                        </select>
                        @error('kategori')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun" class="form-input w-36 @error('tahun') border-red-400 @enderror"
                           value="{{ old('tahun', date('Y')) }}" min="2000" max="{{ date('Y') + 1 }}" required>
                    @error('tahun')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="form-input @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-input @error('foto') border-red-400 @enderror"
                           accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Format gambar. Maks 2MB.</p>
                    @error('foto')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                    <a href="{{ route('admin.prestasi.index') }}" class="btn-outline">Batal</a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
