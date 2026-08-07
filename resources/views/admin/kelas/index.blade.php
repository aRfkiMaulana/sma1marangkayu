@extends('admin.layouts.app')
@section('title', 'Kelola Kelas Buku Tahunan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Buku Tahunan — Kelola Kelas</h1>
        <p class="text-sm text-gray-500">Daftar kelas berdasarkan angkatan lulusan SMAN 1 Marangkayu</p>
    </div>
    <a href="{{ route('admin.angkatan.index') }}" class="btn-secondary">
        <i class="fa-solid fa-arrow-left text-xs mr-1"></i> Kembali ke Angkatan
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 h-fit">
        <h2 class="text-base font-bold text-gray-800 mb-4">Tambah Kelas Baru</h2>
        <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Angkatan <span class="text-red-500">*</span></label>
                <select name="angkatan_id" class="form-input" required>
                    <option value="">-- Pilih Angkatan --</option>
                    @foreach($angkatans as $a)
                    <option value="{{ $a->id }}" {{ request('angkatan_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->nama_angkatan }} ({{ $a->tahun_lulus }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Nama Kelas <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kelas" class="form-input" placeholder="Contoh: XII IPA 1" required>
            </div>
            <button type="submit" class="btn-primary w-full justify-center">
                <i class="fa-solid fa-plus text-xs"></i> Simpan Kelas
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <span class="font-semibold text-gray-800">Daftar Kelas</span>
            <form action="{{ route('admin.kelas.index') }}" method="GET" class="flex items-center gap-2">
                <select name="angkatan_id" class="form-input text-xs py-1" onchange="this.form.submit()">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatans as $a)
                    <option value="{{ $a->id }}" {{ request('angkatan_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->nama_angkatan }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-slate-50 text-gray-700 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Kelas</th>
                        <th class="px-6 py-4">Angkatan</th>
                        <th class="px-6 py-4">Jumlah Siswa</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kelasList as $i => $k)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $k->nama_kelas }}</td>
                        <td class="px-6 py-4">{{ $k->angkatan->nama_angkatan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                {{ $k->siswas->count() }} Siswa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.siswa.index', ['kelas_id' => $k->id]) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg text-xs font-semibold" title="Lihat Siswa">
                                    <i class="fa-solid fa-users mr-1"></i> Data Siswa
                                </a>
                                <a href="{{ route('admin.siswa.export-kode', ['kelas_id' => $k->id]) }}" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg text-xs font-semibold" title="Cetak Kode Unik">
                                    <i class="fa-solid fa-print mr-1"></i> Cetak Kode
                                </a>
                                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini beserta data siswanya?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data kelas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
