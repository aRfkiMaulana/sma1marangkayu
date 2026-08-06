@extends('admin.layouts.app')
@section('title', 'Edit Ekstrakurikuler')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="POST" action="{{ route('admin.ekstrakurikuler.update', $ekstrakurikuler) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid gap-5">

                <div>
                    <label class="form-label">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" class="form-input @error('nama') border-red-400 @enderror"
                           value="{{ old('nama', $ekstrakurikuler->nama) }}" required>
                    @error('nama')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label">Pembina</label>
                    <input type="text" name="pembina" class="form-input"
                           value="{{ old('pembina', $ekstrakurikuler->pembina) }}">
                </div>

                <div>
                    <label class="form-label">Jadwal</label>
                    <input type="text" name="jadwal" class="form-input"
                           value="{{ old('jadwal', $ekstrakurikuler->jadwal) }}"
                           placeholder="Contoh: Setiap Rabu, 14.00–16.00">
                </div>

                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="form-input">{{ old('deskripsi', $ekstrakurikuler->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="form-label">Foto</label>
                    @if($ekstrakurikuler->foto)
                    <img src="{{ Storage::url($ekstrakurikuler->foto) }}"
                         class="h-24 rounded-xl object-cover mb-2" alt="{{ $ekstrakurikuler->nama }}">
                    @endif
                    <input type="file" name="foto" class="form-input" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
                </div>

                {{-- PERSONEL --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="form-label mb-0">Personel / Anggota</label>
                        <button type="button" id="btn-add-personel"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg border transition-colors"
                                style="border-color:var(--color-primary);color:var(--color-primary)"
                                onmouseover="this.style.background='var(--color-primary)';this.style.color='#fff'"
                                onmouseout="this.style.background='';this.style.color='var(--color-primary)'">
                            <i class="fa-solid fa-plus"></i> Tambah Personel
                        </button>
                    </div>
                    <div id="personel-list" class="space-y-2"></div>
                    <p class="text-xs text-gray-400 mt-2">Isi nama dan jabatan setiap personel/anggota ekstrakurikuler.</p>
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_aktif" value="1"
                               {{ old('is_aktif', $ekstrakurikuler->is_aktif) ? 'checked' : '' }}
                               class="w-4 h-4 rounded">
                        <span class="text-sm text-gray-700">Tampilkan di website</span>
                    </label>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Perbarui
                    </button>
                    <a href="{{ route('admin.ekstrakurikuler.index') }}" class="btn-outline">Batal</a>
                </div>

            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let personelIndex = 0;

    function addPersonelRow(nama = '', jabatan = '') {
        const i = personelIndex++;
        const row = document.createElement('div');
        row.className = 'flex gap-2 items-start personel-row';
        row.innerHTML = `
            <div class="flex-1 grid grid-cols-2 gap-2">
                <input type="text" name="personel[${i}][nama]" placeholder="Nama *"
                       class="form-input text-sm" value="${nama}" required>
                <input type="text" name="personel[${i}][jabatan]" placeholder="Jabatan / Peran"
                       class="form-input text-sm" value="${jabatan}">
            </div>
            <button type="button" onclick="this.closest('.personel-row').remove()"
                    class="mt-1 w-8 h-8 flex items-center justify-center rounded-lg border border-red-200 text-red-400 hover:bg-red-50 flex-shrink-0">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>`;
        document.getElementById('personel-list').appendChild(row);
    }

    document.getElementById('btn-add-personel').addEventListener('click', () => addPersonelRow());

    // Pre-fill data yang sudah ada
    @if(old('personel'))
        @foreach(old('personel', []) as $p)
            addPersonelRow('{{ $p['nama'] ?? '' }}', '{{ $p['jabatan'] ?? '' }}');
        @endforeach
    @else
        @foreach($ekstrakurikuler->personel as $p)
            addPersonelRow('{{ $p->nama }}', '{{ $p->jabatan }}');
        @endforeach
    @endif
</script>
@endpush
@endsection
