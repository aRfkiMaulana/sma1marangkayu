@extends('admin.layouts.app')
@section('title', 'Log Aktivitas Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Log Aktivitas (Audit Trail)</h1>
        <p class="text-sm text-gray-500">Catatan riwayat perubahan data yang dilakukan oleh administrator</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-slate-50 text-gray-700 font-semibold border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Aksi</th>
                    <th class="px-6 py-4">Modul</th>
                    <th class="px-6 py-4">Keterangan</th>
                    <th class="px-6 py-4">IP Address</th>
                    <th class="px-6 py-4">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($logs as $index => $log)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4 font-medium">{{ $logs->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        {{ $log->user->name ?? 'System' }}
                        <span class="block text-xs text-gray-400 font-normal">{{ $log->user->email ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $badge = match($log->action) {
                                'create' => 'bg-emerald-100 text-emerald-800',
                                'update' => 'bg-blue-100 text-blue-800',
                                'delete' => 'bg-rose-100 text-rose-800',
                                default  => 'bg-slate-100 text-slate-700'
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ strtoupper($log->action) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">{{ $log->module }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $log->description }}</td>
                    <td class="px-6 py-4 text-xs font-mono text-gray-500">{{ $log->ip_address ?? '-' }}</td>
                    <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada catatan aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
