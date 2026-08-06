@extends('admin.layouts.app')
@section('title', 'Kelola Ekstrakurikuler')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.ekstrakurikuler.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Ekstrakurikuler
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Foto</th>
                    <th class="text-left px-4 py-3">Nama</th>
                    <th class="text-left px-4 py-3">Pembina</th>
                    <th class="text-left px-4 py-3">Jadwal</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($ekstrakurikuler as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <img src="{{ $item->foto ? Storage::url($item->foto) : 'https://placehold.co/48x36/e2e8f0/94a3b8?text=E' }}"
                             class="w-12 h-9 rounded-lg object-cover" alt="">
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $item->nama }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $item->pembina ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $item->jadwal ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($item->is_aktif)
                        <span class="badge badge-green">Aktif</span>
                        @else
                        <span class="badge badge-gray">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.ekstrakurikuler.edit', $item) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.ekstrakurikuler.destroy', $item) }}" class="inline"
                              onsubmit="return confirm('Hapus ekstrakurikuler ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-16">
                        <div class="flex flex-col items-center gap-2 text-gray-400">
                            <i class="fa-regular fa-folder-open text-4xl"></i>
                            <p class="text-sm">Belum ada data ekstrakurikuler.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($ekstrakurikuler->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $ekstrakurikuler->links() }}</div>
    @endif
</div>
@endsection
