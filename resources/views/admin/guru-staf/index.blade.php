@extends('admin.layouts.app')
@section('title', 'Kelola Guru & Staf')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.guru-staf.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah
    </a>
</div>

{{-- GURU --}}
<h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3 flex items-center gap-2">
    <i class="fa-solid fa-chalkboard-user" style="color:var(--color-primary)"></i> Tenaga Pendidik
</h2>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Nama</th>
                    <th class="text-left px-4 py-3">NIP</th>
                    <th class="text-left px-4 py-3">Jabatan / Mapel</th>
                    <th class="text-left px-4 py-3">Pendidikan</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($guru as $g)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $g->foto ? Storage::url($g->foto) : 'https://ui-avatars.com/api/?name='.urlencode($g->nama).'&background=1a3d6e&color=fff&size=36' }}"
                                 class="w-9 h-9 rounded-xl object-cover flex-shrink-0" alt="">
                            <span class="font-medium text-gray-800">{{ $g->nama }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $g->nip ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $g->jabatan ?? $g->mata_pelajaran ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $g->pendidikan_terakhir ?? '-' }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.guru-staf.edit', $g) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.guru-staf.destroy', $g) }}" class="inline"
                              onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400 py-10">Belum ada data guru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- STAF --}}
<h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3 flex items-center gap-2">
    <i class="fa-solid fa-users" style="color:var(--color-accent)"></i> Staf / Tata Usaha
</h2>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Nama</th>
                    <th class="text-left px-4 py-3">NIP</th>
                    <th class="text-left px-4 py-3">Jabatan</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($staf as $s)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $s->foto ? Storage::url($s->foto) : 'https://ui-avatars.com/api/?name='.urlencode($s->nama).'&background=e8a020&color=fff&size=36' }}"
                                 class="w-9 h-9 rounded-xl object-cover flex-shrink-0" alt="">
                            <span class="font-medium text-gray-800">{{ $s->nama }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $s->nip ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $s->jabatan ?? '-' }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.guru-staf.edit', $s) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.guru-staf.destroy', $s) }}" class="inline"
                              onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-gray-400 py-10">Belum ada data staf.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
