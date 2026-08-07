@extends('admin.layouts.app')
@section('title', 'Manajemen Pengelola CMS')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Manajemen Pengelola CMS</h1>
        <p class="text-sm text-gray-500">Kelola akun staf/administrator pengelola website sekolah</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus text-xs"></i> Tambah Pengelola
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-slate-50 text-gray-700 font-semibold border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama Pengelola</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Akses</th>
                    <th class="px-6 py-4">Tgl Dibuat</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $index => $u)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4 font-medium">{{ $users->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $u->name }}</td>
                    <td class="px-6 py-4">{{ $u->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            ADMINISTRATOR
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $u->created_at->format('d M Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @if(auth()->id() !== $u->id)
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pengelola ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data pengelola.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
