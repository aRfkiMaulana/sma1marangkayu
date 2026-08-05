@extends('admin.layouts.app')
@section('title', 'Pesan Masuk')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Pengirim</th>
                    <th class="text-left px-4 py-3">Subjek</th>
                    <th class="text-left px-4 py-3">Telepon</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Waktu</th>
                    <th class="text-right px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pesan as $p)
                <tr class="hover:bg-slate-50 transition-colors {{ !$p->is_read ? 'bg-blue-50/40' : '' }}">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-800 {{ !$p->is_read ? 'font-semibold' : '' }}">{{ $p->nama }}</p>
                        <p class="text-xs text-gray-400">{{ $p->email }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-700">{{ Str::limit($p->subjek, 45) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $p->telepon ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if(!$p->is_read)
                        <span class="badge bg-red-100 text-red-600">Baru</span>
                        @else
                        <span class="badge badge-gray">Dibaca</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $p->created_at->diffForHumans() }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.pesan.show', $p) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 transition-colors mr-1">
                            <i class="fa-solid fa-eye"></i> Baca
                        </a>
                        <form method="POST" action="{{ route('admin.pesan.destroy', $p) }}" class="inline"
                              onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200 text-gray-600 hover:border-red-300 hover:text-red-600 transition-colors">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-gray-400 py-12">Tidak ada pesan masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">{{ $pesan->links() }}</div>
</div>
@endsection
