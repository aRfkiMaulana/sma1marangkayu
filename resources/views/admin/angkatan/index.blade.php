@extends('admin.layouts.app')
@section('title', 'Kelola Angkatan Buku Tahunan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Buku Tahunan — Kelola Angkatan</h1>
        <p class="text-sm text-gray-500">Daftar angkatan lulusan SMAN 1 Marangkayu</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 h-fit">
        <h2 class="text-base font-bold text-gray-800 mb-4">Tambah Angkatan Baru</h2>
        <form action="{{ route('admin.angkatan.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Nama Angkatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_angkatan" class="form-input" placeholder="Contoh: Angkatan 25 / Spartan" required>
            </div>
            <div>
                <label class="form-label">Tahun Lulus <span class="text-red-500">*</span></label>
                <input type="number" name="tahun_lulus" class="form-input" value="{{ date('Y') }}" min="2000" max="{{ date('Y') + 1 }}" required>
            </div>
            <button type="submit" class="btn-primary w-full justify-center">
                <i class="fa-solid fa-plus text-xs"></i> Simpan Angkatan
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 font-semibold text-gray-800">Daftar Angkatan</div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-slate-50 text-gray-700 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Angkatan</th>
                        <th class="px-6 py-4">Tahun Lulus</th>
                        <th class="px-6 py-4">Jumlah Siswa</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($angkatans as $i => $a)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium">{{ $i + 1 }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $a->nama_angkatan }}</td>
                        <td class="px-6 py-4">{{ $a->tahun_lulus }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                {{ $a->siswas_count }} Siswa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.kelas.index', ['angkatan_id' => $a->id]) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg text-xs font-semibold" title="Lihat Kelas">
                                    <i class="fa-solid fa-list mr-1"></i> Kelola Kelas
                                </a>
                                <form action="{{ route('admin.angkatan.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus angkatan ini beserta data siswanya?')">
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada data angkatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
