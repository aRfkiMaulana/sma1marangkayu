@extends('admin.layouts.app')
@section('title', 'Kelola Berita')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.berita.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Berita
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Judul</th>
                    <th class="text-left px-4 py-3">Tipe</th>
                    <th class="text-left px-4 py-3">Kategori</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Tanggal</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($berita as $b)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/40x30/e2e8f0/94a3b8?text=B' }}"
                                 class="w-10 h-8 rounded-lg object-cover flex-shrink-0" alt="">
                            <span class="font-medium text-gray-800">{{ Str::limit($b->judul, 50) }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="badge badge-primary">{{ ucfirst($b->tipe) }}</span></td>
                    <td class="px-4 py-3 text-gray-500">{{ $b->kategori->nama ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($b->status === 'published')
                        <span class="badge badge-green">Published</span>
                        @else
                        <span class="badge badge-gray">Draft</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $b->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.berita.edit', $b) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.berita.destroy', $b) }}" class="inline"
                              onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-gray-400 py-12">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">{{ $berita->links() }}</div>
</div>
@endsection
