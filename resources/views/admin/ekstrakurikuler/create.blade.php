@extends('admin.layouts.app')
@section('title', 'Tambah Ekstrakurikuler')

@section('content')
<div class="grid lg:grid-cols-5 gap-6">

    {{-- ── FORM UTAMA (kiri, 3 kolom) ────────────────────── --}}
    <div class="lg:col-span-3">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <form id="ekskul-form" method="POST" action="{{ route('admin.ekstrakurikuler.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-5">

                    <div>
                        <label class="form-label">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" class="form-input @error('nama') border-red-400 @enderror"
                               value="{{ old('nama') }}" required>
                        @error('nama')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label">Pembina</label>
                        <input type="text" name="pembina" class="form-input"
                               value="{{ old('pembina') }}" placeholder="Nama pembina ekstrakurikuler">
                    </div>

                    <div>
                        <label class="form-label">Jadwal</label>
                        <input type="text" name="jadwal" class="form-input"
                               value="{{ old('jadwal') }}" placeholder="Contoh: Setiap Rabu, 14.00–16.00">
                    </div>

                    <div>
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="form-input">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div>
                        <label class="form-label">Foto</label>
                        <input type="file" name="foto" class="form-input" accept="image/*">
                        <p class="text-xs text-gray-400 mt-1">Format gambar. Maks 2MB.</p>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_aktif" value="1"
                                   {{ old('is_aktif', true) ? 'checked' : '' }} class="w-4 h-4 rounded">
                            <span class="text-sm text-gray-700">Tampilkan di website</span>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                        <a href="{{ route('admin.ekstrakurikuler.index') }}" class="btn-outline">Batal</a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ── PERSONEL (kanan, 2 kolom) ──────────────────────── --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-0.5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 text-sm">Personel / Anggota</h3>
                <button type="button" id="btn-add-personel"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg border transition-colors"
                        style="border-color:var(--color-primary);color:var(--color-primary)"
                        onmouseover="this.style.background='var(--color-primary)';this.style.color='#fff'"
                        onmouseout="this.style.background='';this.style.color='var(--color-primary)'">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </div>

            <div id="personel-list" class="space-y-2 max-h-[420px] overflow-y-auto pr-1">
                {{-- Rows diisi JS --}}
            </div>

            <p class="text-xs text-gray-400 mt-3 pt-3 border-t border-gray-100">
                Input akan disertakan saat form disimpan.
            </p>
        </div>
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
            <div class="flex-1 grid gap-1.5">
                <input type="text" name="personel[${i}][nama]" placeholder="Nama *"
                       form="ekskul-form" class="form-input text-sm py-2" value="${nama}" required>
                <input type="text" name="personel[${i}][jabatan]" placeholder="Jabatan / Peran"
                       form="ekskul-form" class="form-input text-sm py-2" value="${jabatan}">
            </div>
            <button type="button" onclick="this.closest('.personel-row').remove()"
                    class="mt-1 w-7 h-7 flex items-center justify-center rounded-lg border border-red-200 text-red-400 hover:bg-red-50 shrink-0">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>`;
        document.getElementById('personel-list').appendChild(row);
    }

    document.getElementById('btn-add-personel').addEventListener('click', () => addPersonelRow());

    @foreach(old('personel', []) as $p)
        addPersonelRow('{{ $p['nama'] ?? '' }}', '{{ $p['jabatan'] ?? '' }}');
    @endforeach
</script>
@endpush
@endsection
