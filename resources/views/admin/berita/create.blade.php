@extends('admin.layouts.app')
@section('title', 'Tambah Berita')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" class="form-input @error('judul') ring-1 ring-red-400 border-red-400 @enderror"
                           value="{{ old('judul') }}" required>
                    @error('judul')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-input">
                            @foreach(['berita'=>'Berita','pengumuman'=>'Pengumuman','agenda'=>'Agenda'] as $v=>$l)
                            <option value="{{ $v }}" {{ old('tipe','berita') === $v ? 'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-input">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected':'' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="draft" {{ old('status','draft') === 'draft' ? 'selected':'' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected':'' }}>Published</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label">Ringkasan</label>
                    <textarea name="ringkasan" class="form-input" rows="2"
                              placeholder="Ringkasan singkat (opsional)">{{ old('ringkasan') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Konten <span class="text-red-500">*</span></label>
                    <textarea name="konten" class="form-input @error('konten') ring-1 ring-red-400 border-red-400 @enderror"
                              rows="14">{{ old('konten') }}</textarea>
                    @error('konten')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-input" accept="image/*">
                        <p class="text-xs text-gray-400 mt-1">Format jpg/png/webp, maks 2MB</p>
                    </div>
                    <div>
                        <label class="form-label">Tanggal Publish</label>
                        <input type="datetime-local" name="tanggal_publish" class="form-input" value="{{ old('tanggal_publish') }}">
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                    <a href="{{ route('admin.berita.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
