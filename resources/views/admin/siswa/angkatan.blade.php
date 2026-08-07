@extends('admin.layouts.app')
@section('title', 'Daftar Kode Unik - ' . $angkatan->nama_angkatan)

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Buku Tahunan — Kode Unik Siswa</h1>
        <p class="text-sm text-gray-500">Angkatan: <strong>{{ $angkatan->nama_angkatan }}</strong> ({{ $angkatan->tahun_lulus }})</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.angkatan.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn-primary">
            <i class="fa-solid fa-print text-xs"></i> Print Kode Unik
        </button>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-6">
    <div class="mb-4 bg-blue-50 border border-blue-100 text-blue-800 rounded-xl p-4 text-xs">
        <i class="fa-solid fa-circle-info mr-1"></i> Bagikan NISN dan Kode Unik ini kepada masing-masing siswa melalui wali kelas untuk mengisi foto dan moto buku tahunan.
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-slate-50 text-gray-700 font-semibold border-b border-slate-100">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">NISN</th>
                    <th class="px-4 py-3">Nama Siswa</th>
                    <th class="px-4 py-3">Kode Unik</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-mono">
                @forelse($siswas as $i => $s)
                <tr>
                    <td class="px-4 py-3 text-gray-400 font-sans">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-bold text-gray-800">{{ $s->nisn }}</td>
                    <td class="px-4 py-3 font-sans font-semibold text-gray-900">{{ $s->nama }}</td>
                    <td class="px-4 py-3 text-blue-600 font-bold tracking-widest text-base">{{ $s->kode_unik }}</td>
                    <td class="px-4 py-3 font-sans">
                        @if($s->status === 'approved')
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">APPROVED</span>
                        @elseif($s->status === 'pending')
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">PENDING APPROVAL</span>
                        @elseif($s->status === 'rejected')
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">REJECTED</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">BELUM ISI</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400 font-sans">Belum ada siswa di angkatan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
