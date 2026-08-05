@extends('admin.layouts.app')
@section('title', 'Tambah Guru / Staf')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.guru-staf.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-5">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" class="form-input" value="{{ old('nama') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Tipe <span class="text-red-500">*</span></label>
                        <select name="tipe" class="form-input">
                            <option value="guru" {{ old('tipe') === 'guru' ? 'selected':'' }}>Guru</option>
                            <option value="staf" {{ old('tipe') === 'staf' ? 'selected':'' }}>Staf / TU</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-input" value="{{ old('nip') }}">
                    </div>
                    <div>
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-input" value="{{ old('jabatan') }}">
                    </div>
                    <div>
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-input" value="{{ old('mata_pelajaran') }}">
                    </div>
                    <div>
                        <label class="form-label">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" class="form-input"
                               value="{{ old('pendidikan_terakhir') }}" placeholder="S1, S2, dll.">
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', 0) }}">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Foto</label>
                        <input type="file" name="foto" class="form-input" accept="image/*">
                        <p class="text-xs text-gray-400 mt-1">Format jpg/png, maks 2MB</p>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    <a href="{{ route('admin.guru-staf.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
