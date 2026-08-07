@extends('admin.layouts.app')
@section('title', 'Manajemen Buku Tahunan Siswa')

@section('content')
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Buku Tahunan — Data & Approval Siswa</h1>
        <p class="text-sm text-gray-500">Import Excel per kelas, filter data, dan approve foto/moto siswa</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.angkatan.index') }}" class="btn-secondary">
            <i class="fa-solid fa-layer-group text-xs"></i> Kelola Angkatan
        </a>
        <a href="{{ route('admin.kelas.index') }}" class="btn-secondary">
            <i class="fa-solid fa-chalkboard-user text-xs"></i> Kelola Kelas
        </a>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    {{-- IMPORT EXCEL --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-base font-bold text-gray-800 mb-2">Import Siswa via Excel</h2>
        <p class="text-xs text-gray-500 mb-4">Pilih kelas tujuan. Format kolom: <code>nisn</code>, <code>nama</code></p>
        <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Pilih Kelas Tujuan <span class="text-red-500">*</span></label>
                <select name="kelas_id" class="form-input" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                    <option value="{{ $k->id }}">
                        {{ $k->nama_kelas }} ({{ $k->angkatan->nama_angkatan ?? '-' }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">File Excel (.xlsx / .csv) <span class="text-red-500">*</span></label>
                <input type="file" name="file" class="form-input" accept=".xlsx,.xls,.csv" required>
            </div>
            <button type="submit" class="btn-primary w-full justify-center">
                <i class="fa-solid fa-file-import text-xs"></i> Import Excel Siswa
            </button>
        </form>
    </div>

    {{-- STATS & FILTER --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-base font-bold text-gray-800 mb-4">Filter Data Siswa</h2>
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">Angkatan</label>
                    <select name="angkatan_id" class="form-input" onchange="this.form.submit()">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatans as $a)
                        <option value="{{ $a->id }}" {{ request('angkatan_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->nama_angkatan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-input" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>PENDING (Review)</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>APPROVED</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>REJECTED</option>
                        <option value="kosong" {{ request('status') == 'kosong' ? 'selected' : '' }}>BELUM ISI</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Cari Nama/NISN</label>
                    <input type="text" name="search" class="form-input" placeholder="Nama / NISN..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-slate-50 text-gray-700 font-semibold border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Foto</th>
                    <th class="px-6 py-4">Siswa</th>
                    <th class="px-6 py-4">Kelas & Angkatan</th>
                    <th class="px-6 py-4">Kode Unik</th>
                    <th class="px-6 py-4">Moto</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi & Approval</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($siswas as $s)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4">
                        @if($s->foto)
                            <img src="{{ Storage::url($s->foto) }}" class="w-12 h-14 object-cover rounded-lg border border-slate-200" alt="Foto">
                        @else
                            <div class="w-12 h-14 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs">No Pic</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-900">{{ $s->nama }}</p>
                        <p class="text-xs text-gray-400">NISN: {{ $s->nisn }}</p>
                    </td>
                    <td class="px-6 py-4 text-xs font-semibold text-gray-700">
                        <p class="text-gray-900">{{ $s->kelas->nama_kelas ?? '-' }}</p>
                        <p class="text-gray-400 text-[11px]">{{ $s->kelas->angkatan->nama_angkatan ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 font-mono font-bold text-blue-600">{{ $s->kode_unik }}</td>
                    <td class="px-6 py-4 text-xs max-w-xs truncate text-gray-500 italic">"{{ $s->moto ?? '-' }}"</td>
                    <td class="px-6 py-4">
                        @if($s->status === 'approved')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">APPROVED</span>
                        @elseif($s->status === 'pending')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 animate-pulse">PENDING REVIEW</span>
                        @elseif($s->status === 'rejected')
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">REJECTED</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">BELUM ISI</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($s->status === 'pending')
                            <form action="{{ route('admin.siswa.approve', $s->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.siswa.reject', $s->id) }}" method="POST" onsubmit="return confirm('Tolak dan minta siswa submit ulang?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-xmark"></i> Reject
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?')">
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
                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($siswas->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $siswas->links() }}
    </div>
    @endif
</div>
@endsection
