@extends('admin.layouts.app')
@section('title', 'Kelola Fasilitas')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.fasilitas.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Fasilitas
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Fasilitas</th>
                    <th class="text-left px-4 py-3">Kategori</th>
                    <th class="text-left px-4 py-3">Jumlah</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($fasilitas as $f)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $f->foto ? Storage::url($f->foto) : 'https://placehold.co/40x32/e2e8f0/94a3b8?text=F' }}"
                                 class="w-10 h-8 rounded-lg object-cover flex-shrink-0" alt="">
                            <span class="font-medium text-gray-800">{{ $f->nama }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $f->kategori ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $f->jumlah }}</td>
                    <td class="px-4 py-3">
                        @if($f->is_aktif)
                        <span class="badge badge-green">Aktif</span>
                        @else
                        <span class="badge badge-gray">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.fasilitas.edit', $f) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.fasilitas.destroy', $f) }}" class="inline"
                              onsubmit="return confirm('Hapus fasilitas ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400 py-12">Belum ada fasilitas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">{{ $fasilitas->links() }}</div>
</div>
@endsection
