@extends('admin.layouts.app')
@section('title', 'Edit Berita')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.berita.update', $berita) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-5">
                <div>
                    <label class="form-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" class="form-input" value="{{ old('judul', $berita->judul) }}" required>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-input">
                            @foreach(['berita'=>'Berita','pengumuman'=>'Pengumuman','agenda'=>'Agenda'] as $v=>$l)
                            <option value="{{ $v }}" {{ old('tipe', $berita->tipe) === $v ? 'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-input">
                            <option value="">-- Pilih --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id', $berita->kategori_id) == $k->id ? 'selected':'' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="draft" {{ old('status', $berita->status) === 'draft' ? 'selected':'' }}>Draft</option>
                            <option value="published" {{ old('status', $berita->status) === 'published' ? 'selected':'' }}>Published</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label">Ringkasan</label>
                    <textarea name="ringkasan" class="form-input" rows="2">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                </div>

                <div>
                    <label class="form-label">Konten <span class="text-red-500">*</span></label>
                    <textarea name="konten" class="form-input" rows="14">{{ old('konten', $berita->konten) }}</textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Thumbnail</label>
                        @if($berita->thumbnail)
                        <img src="{{ Storage::url($berita->thumbnail) }}" class="h-20 rounded-lg object-cover mb-2" alt="">
                        @endif
                        <input type="file" name="thumbnail" class="form-input" accept="image/*">
                    </div>
                    <div>
                        <label class="form-label">Tanggal Publish</label>
                        <input type="datetime-local" name="tanggal_publish" class="form-input"
                               value="{{ old('tanggal_publish', $berita->tanggal_publish?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui
                    </button>
                    <a href="{{ route('admin.berita.index') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
