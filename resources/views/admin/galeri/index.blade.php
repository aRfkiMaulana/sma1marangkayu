@extends('admin.layouts.app')
@section('title', 'Kelola Galeri')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.galeri.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Item
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Item</th>
                    <th class="text-left px-4 py-3">Tipe</th>
                    <th class="text-left px-4 py-3">Album</th>
                    <th class="text-left px-4 py-3">Highlight</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($galeri as $g)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $g->tipe === 'foto' ? Storage::url($g->file) : 'https://placehold.co/50x40/1a3d6e/fff?text=Vid' }}"
                                 class="w-12 h-10 rounded-lg object-cover flex-shrink-0" alt="">
                            <span class="font-medium text-gray-700">{{ Str::limit($g->judul, 45) }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="badge {{ $g->tipe === 'foto' ? 'badge-primary' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($g->tipe) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $g->album ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($g->is_highlight)
                        <i class="fa-solid fa-star text-yellow-400"></i>
                        @else
                        <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.galeri.edit', $g) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.galeri.destroy', $g) }}" class="inline"
                              onsubmit="return confirm('Hapus item ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400 py-12">Galeri kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">{{ $galeri->links() }}</div>
</div>
@endsection
