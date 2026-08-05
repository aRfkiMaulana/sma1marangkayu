@extends('admin.layouts.app')
@section('title', 'Edit Guru / Staf')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.guru-staf.update', $guruStaf) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-5">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-input" value="{{ old('nama', $guruStaf->nama) }}" required>
                    </div>
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-input">
                            <option value="guru" {{ old('tipe',$guruStaf->tipe) === 'guru' ? 'selected':'' }}>Guru</option>
                            <option value="staf" {{ old('tipe',$guruStaf->tipe) === 'staf' ? 'selected':'' }}>Staf / TU</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-input" value="{{ old('nip', $guruStaf->nip) }}">
                    </div>
                    <div>
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-input" value="{{ old('jabatan', $guruStaf->jabatan) }}">
                    </div>
                    <div>
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-input" value="{{ old('mata_pelajaran', $guruStaf->mata_pelajaran) }}">
                    </div>
                    <div>
                        <label class="form-label">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" class="form-input" value="{{ old('pendidikan_terakhir', $guruStaf->pendidikan_terakhir) }}">
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $guruStaf->email) }}">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-input" value="{{ old('urutan', $guruStaf->urutan) }}">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Foto</label>
                        @if($guruStaf->foto)
                        <img src="{{ Storage::url($guruStaf->foto) }}" class="w-16 h-16 rounded-xl object-cover mb-2" alt="">
                        @endif
                        <input type="file" name="foto" class="form-input" accept="image/*">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_aktif" value="1"
                                   {{ $guruStaf->is_aktif ? 'checked':'' }}
                                   class="w-4 h-4 rounded accent-blue-800">
                            <span class="text-sm text-gray-700">Status Aktif</span>
                        </label>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui</button>
                    <a href="{{ route('admin.guru-staf.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
