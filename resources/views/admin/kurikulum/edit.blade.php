@extends('admin.layouts.app')
@section('title', 'CMS Pengaturan Kurikulum')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Pengaturan Halaman Kurikulum</h1>
        <p class="text-sm text-gray-500">Kelola secara dinamis bagian Hero, Deskripsi, Tujuan, Struktur, Fakta, Tahapan, & Dokumen KOS (Tambah/Hapus Baris Bebas)</p>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3 text-sm font-semibold">
    <i class="fa-solid fa-circle-check text-lg"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<form action="{{ route('admin.kurikulum.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="kurikulumForm()">
    @csrf
    @method('PUT')

    @php
        $meta = $kurikulum->meta_data ?? [];
        $tujuanDefault = [
            ['judul'=>'Pembelajaran Berpusat Siswa','desc'=>'Siswa menjadi subjek aktif dalam proses pembelajaran, bukan sekadar penerima informasi pasif dari guru.'],
            ['judul'=>'Penguatan Profil Pelajar Pancasila','desc'=>'Membentuk karakter siswa yang beriman, berkebinekaan global, bergotong royong, kreatif, bernalar kritis, dan mandiri.'],
            ['judul'=>'Pembelajaran Berbasis Proyek','desc'=>'Siswa mengerjakan proyek nyata yang relevan dengan kehidupan sehari-hari untuk mengembangkan kompetensi lintas mata pelajaran.'],
            ['judul'=>'Fleksibilitas Pembelajaran','desc'=>'Guru leluasa memilih metode, media, dan perangkat ajar terbaik sesuai kebutuhan dan karakteristik siswa di kelas.'],
            ['judul'=>'Pengembangan Kompetensi Holistik','desc'=>'Tidak hanya kognitif, namun juga afektif dan psikomotorik untuk menyiapkan lulusan yang siap menghadapi tantangan global.'],
        ];
        $tujuanList = !empty($meta['tujuan']) ? $meta['tujuan'] : $tujuanDefault;

        $strukturDefault = [
            'Mata pelajaran wajib meliputi: Pendidikan Agama, PPKn, Bahasa Indonesia, Matematika, Bahasa Inggris, PJOK, dan Seni Budaya',
            'Mata pelajaran pilihan (fase F) sesuai minat dan bakat siswa: IPA, IPS, atau campuran lintas bidang',
            'Projek Penguatan Profil Pelajar Pancasila (P5) sebanyak 20–30% dari total jam pelajaran',
            'Pemilihan mata pelajaran pilihan dimulai di kelas XI berdasarkan minat, bakat, dan rencana studi lanjut',
            'Tidak ada lagi penjurusan IPA/IPS di kelas X — semua siswa mengikuti kurikulum yang sama',
            'Asesmen berbasis kompetensi: formatif, sumatif, dan projek nyata',
            'Program remedial dan pengayaan terintegrasi dalam siklus pembelajaran',
        ];
        $strukturList = !empty($meta['struktur']) ? $meta['struktur'] : $strukturDefault;

        $faktaDefault = [
            ['label'=>'Kurikulum', 'value'=>'Kurikulum Merdeka'],
            ['label'=>'Diterapkan sejak', 'value'=>'T.A. 2023/2024'],
            ['label'=>'Fase', 'value'=>'Fase E (X) & F (XI–XII)'],
            ['label'=>'Penjurusan', 'value'=>'Tidak ada di kelas X'],
            ['label'=>'Program P5', 'value'=>'20–30% Jam Pelajaran'],
            ['label'=>'Asesmen', 'value'=>'Berbasis Kompetensi'],
        ];
        $faktaList = !empty($meta['fakta']) ? $meta['fakta'] : $faktaDefault;

        $tahapanDefault = [
            ['judul'=>'Sosialisasi & Pelatihan Guru','desc'=>'Seluruh guru mengikuti pelatihan Implementasi Kurikulum Merdeka (IKM) dari Kemendikbud.'],
            ['judul'=>'Penyusunan Kurikulum Operasional','desc'=>'Sekolah menyusun KOSP (Kurikulum Operasional Satuan Pendidikan) sesuai kondisi lokal.'],
            ['judul'=>'Implementasi Pembelajaran','desc'=>'Penerapan modul ajar, ATP, dan P5 di semua kelas secara bertahap.'],
            ['judul'=>'Asesmen & Evaluasi','desc'=>'Penilaian berbasis kompetensi, laporan hasil belajar, dan evaluasi program P5.'],
        ];
        $tahapanList = !empty($meta['tahapan']) ? $meta['tahapan'] : $tahapanDefault;
    @endphp

    {{-- SECTION 1: HERO & DESKRIPSI UTAMA --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
        <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-heading text-blue-600"></i> 1. Hero & Deskripsi Utama
        </h2>
        <div>
            <label class="form-label">Judul Utama <span class="text-red-500">*</span></label>
            <input type="text" name="judul" class="form-input" required value="{{ old('judul', $kurikulum->judul ?? 'Kurikulum Merdeka') }}">
        </div>
        <div>
            <label class="form-label">Subjudul (Deskripsi Singkat Banner Hero)</label>
            <input type="text" name="subjudul" class="form-input" value="{{ old('subjudul', $meta['subjudul'] ?? 'SMA Negeri 1 Marangkayu menerapkan Kurikulum Merdeka sebagai pedoman penyelenggaraan pembelajaran yang berpusat pada siswa, fleksibel, dan relevan dengan kebutuhan zaman.') }}">
        </div>
        <div>
            <label class="form-label">Penjelasan "Apa itu Kurikulum Merdeka?" <span class="text-red-500">*</span></label>
            <textarea name="konten" class="form-input" rows="6" required>{{ old('konten', $kurikulum->konten ?? "Kurikulum Merdeka adalah kurikulum dengan pembelajaran intrakurikuler yang beragam, di mana konten akan lebih optimal agar siswa memiliki cukup waktu untuk mendalami konsep dan menguatkan kompetensi.\n\nKurikulum ini memberikan keleluasaan bagi guru untuk memilih perangkat ajar yang sesuai dengan kebutuhan dan karakteristik peserta didik, serta memberikan ruang bagi satuan pendidikan untuk mengembangkan kurikulum operasional sesuai kondisi setempat.\n\nDi SMAN 1 Marangkayu, Kurikulum Merdeka diterapkan secara penuh dengan pendekatan pembelajaran berbasis proyek (Project-Based Learning) dan penguatan profil pelajar Pancasila.") }}</textarea>
        </div>
    </div>

    {{-- SECTION 2: TUJUAN PENERAPAN --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-bullseye text-blue-600"></i> 2. Tujuan Penerapan Kurikulum
            </h2>
            <button type="button" @click="addTujuan()" class="btn-secondary text-xs">
                <i class="fa-solid fa-plus"></i> Tambah Tujuan
            </button>
        </div>
        <div class="space-y-3">
            <template x-for="(item, index) in tujuan" :key="index">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 relative group space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-500" x-text="'Tujuan #' + (index + 1)"></span>
                        <button type="button" @click="removeTujuan(index)" class="p-1 text-red-500 hover:bg-red-50 rounded text-xs font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <label class="form-label text-xs">Judul Tujuan</label>
                            <input type="text" :name="'tujuan[' + index + '][judul]'" x-model="item.judul" class="form-input text-xs" placeholder="Contoh: Pembelajaran Berpusat Siswa">
                        </div>
                        <div>
                            <label class="form-label text-xs">Deskripsi Singkat</label>
                            <input type="text" :name="'tujuan[' + index + '][desc]'" x-model="item.desc" class="form-input text-xs" placeholder="Penjelasan singkat tujuan...">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- SECTION 3: STRUKTUR KURIKULUM --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-blue-600"></i> 3. Poin-poin Struktur Kurikulum
            </h2>
            <button type="button" @click="addStruktur()" class="btn-secondary text-xs">
                <i class="fa-solid fa-plus"></i> Tambah Poin Struktur
            </button>
        </div>
        <div class="space-y-3">
            <template x-for="(item, index) in struktur" :key="index">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-800 font-bold text-xs flex items-center justify-center shrink-0">✓</span>
                    <input type="text" name="struktur[]" x-model="struktur[index]" class="form-input text-xs" placeholder="Poin struktur kurikulum...">
                    <button type="button" @click="removeStruktur(index)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </template>
        </div>
    </div>

    {{-- SECTION 4: FAKTA KURIKULUM & TAHAPAN --}}
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-600"></i> 4. Sidebar Fakta Kurikulum
                </h2>
                <button type="button" @click="addFakta()" class="btn-secondary text-xs">
                    <i class="fa-solid fa-plus"></i> Tambah Fakta
                </button>
            </div>
            <div class="space-y-3">
                <template x-for="(item, index) in fakta" :key="index">
                    <div class="flex items-center gap-2">
                        <input type="text" :name="'fakta[' + index + '][label]'" x-model="item.label" class="form-input text-xs" placeholder="Label">
                        <input type="text" :name="'fakta[' + index + '][value]'" x-model="item.value" class="form-input text-xs" placeholder="Nilai">
                        <button type="button" @click="removeFakta(index)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg shrink-0">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-ol text-blue-600"></i> 5. Tahapan Implementasi
                </h2>
                <button type="button" @click="addTahapan()" class="btn-secondary text-xs">
                    <i class="fa-solid fa-plus"></i> Tambah Tahapan
                </button>
            </div>
            <div class="space-y-3">
                <template x-for="(item, index) in tahapan" :key="index">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-2 relative">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-500" x-text="'Langkah #' + (index + 1)"></span>
                            <button type="button" @click="removeTahapan(index)" class="text-red-500 hover:bg-red-50 p-1 rounded text-xs">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                        <input type="text" :name="'tahapan[' + index + '][judul]'" x-model="item.judul" class="form-input text-xs font-bold" placeholder="Judul Tahapan">
                        <input type="text" :name="'tahapan[' + index + '][desc]'" x-model="item.desc" class="form-input text-xs" placeholder="Deskripsi Singkat">
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- SECTION 5: DOKUMEN KOS PDF --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
        <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-file-pdf text-red-600"></i> 6. Dokumen KOS (Kurikulum Operasional Sekolah)
        </h2>
        @if($kurikulum && $kurikulum->file_lampiran)
            <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs text-gray-600">
                <i class="fa-solid fa-file-pdf text-red-500 text-base"></i>
                <span class="truncate">Dokumen Aktif: <a href="{{ Storage::url($kurikulum->file_lampiran) }}" target="_blank" class="text-blue-600 underline font-semibold">Unduh Dokumen KOS (PDF)</a></span>
            </div>
        @endif
        <input type="file" name="file_lampiran" class="form-input" accept=".pdf,.doc,.docx">
        <p class="text-xs text-gray-400">Unggah file dokumen resmi SK/KOS Kurikulum. Format: PDF, DOC, DOCX. Maks: 10MB.</p>
    </div>

    <div class="flex justify-end pt-4">
        <button type="submit" class="btn-primary text-base px-8 py-3">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Semua Perubahan Kurikulum
        </button>
    </div>
</form>

<script>
function kurikulumForm() {
    return {
        tujuan: @json($tujuanList),
        struktur: @json($strukturList),
        fakta: @json($faktaList),
        tahapan: @json($tahapanList),

        addTujuan() {
            this.tujuan.push({ judul: '', desc: '' });
        },
        removeTujuan(index) {
            this.tujuan.splice(index, 1);
        },

        addStruktur() {
            this.struktur.push('');
        },
        removeStruktur(index) {
            this.struktur.splice(index, 1);
        },

        addFakta() {
            this.fakta.push({ label: '', value: '' });
        },
        removeFakta(index) {
            this.fakta.splice(index, 1);
        },

        addTahapan() {
            this.tahapan.push({ judul: '', desc: '' });
        },
        removeTahapan(index) {
            this.tahapan.splice(index, 1);
        }
    }
}
</script>
@endsection
