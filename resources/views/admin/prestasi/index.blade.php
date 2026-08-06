@extends('admin.layouts.app')
@section('title', 'Kelola Prestasi')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.prestasi.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Prestasi
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Foto</th>
                    <th class="text-left px-4 py-3">Judul</th>
                    <th class="text-left px-4 py-3">Peraih</th>
                    <th class="text-left px-4 py-3">Tingkat</th>
                    <th class="text-left px-4 py-3">Kategori</th>
                    <th class="text-center px-4 py-3">Tahun</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($prestasi as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <img src="{{ $item->foto ? Storage::url($item->foto) : 'https://placehold.co/48x36/e2e8f0/94a3b8?text=P' }}"
                             class="w-12 h-9 rounded-lg object-cover" alt="">
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800 max-w-xs">
                        <p class="truncate">{{ $item->judul }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $item->peraih ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php
                            $tingkat_class = [
                                'sekolah'        => 'badge-gray',
                                'kecamatan'      => 'badge-gray',
                                'kabupaten'      => 'badge-primary',
                                'provinsi'       => 'badge-primary',
                                'nasional'       => 'badge-green',
                                'internasional'  => 'badge-green',
                            ];
                            $tingkat_label = [
                                'sekolah'        => 'Sekolah',
                                'kecamatan'      => 'Kecamatan',
                                'kabupaten'      => 'Kabupaten',
                                'provinsi'       => 'Provinsi',
                                'nasional'       => 'Nasional',
                                'internasional'  => 'Internasional',
                            ];
                        @endphp
                        <span class="badge {{ $tingkat_class[$item->tingkat] ?? 'badge' }}">
                            {{ $tingkat_label[$item->tingkat] ?? $item->tingkat }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 capitalize">
                        {{ str_replace('_', ' ', $item->kategori) }}
                    </td>
                    <td class="px-4 py-3 text-center text-gray-600">{{ $item->tahun }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.prestasi.edit', $item) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.prestasi.destroy', $item) }}" class="inline"
                              onsubmit="return confirm('Hapus data prestasi ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-16">
                        <div class="flex flex-col items-center gap-2 text-gray-400">
                            <i class="fa-regular fa-folder-open text-4xl"></i>
                            <p class="text-sm">Belum ada data prestasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($prestasi->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $prestasi->links() }}</div>
    @endif
</div>
@endsection
