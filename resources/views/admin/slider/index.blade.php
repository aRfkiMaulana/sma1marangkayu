@extends('admin.layouts.app')
@section('title', 'Kelola Slider')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.slider.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Slider
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Gambar</th>
                    <th class="text-left px-4 py-3">Judul</th>
                    <th class="text-left px-4 py-3">Subjudul</th>
                    <th class="text-left px-4 py-3">Urutan</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($sliders as $s)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3">
                        <img src="{{ Storage::url($s->gambar) }}"
                             class="w-24 h-14 rounded-xl object-cover"
                             onerror="this.src='https://placehold.co/96x56/e2e8f0/94a3b8?text=Slider'"
                             alt="">
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $s->judul ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ Str::limit($s->subjudul, 40) ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $s->urutan }}</td>
                    <td class="px-4 py-3">
                        @if($s->is_aktif)
                        <span class="badge badge-green">Aktif</span>
                        @else
                        <span class="badge badge-gray">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.slider.edit', $s) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.slider.destroy', $s) }}" class="inline"
                              onsubmit="return confirm('Hapus slider ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-gray-400 py-12">Belum ada slider.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
