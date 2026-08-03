@extends('admin.layouts.app')
@section('title', 'Pesan Masuk')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Pengirim</th><th>Subjek</th><th>Telepon</th><th>Status</th><th>Waktu</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($pesan as $p)
                <tr class="{{ !$p->is_read ? 'fw-600' : '' }}">
                    <td>{{ $p->nama }}<br><small class="text-muted fw-normal">{{ $p->email }}</small></td>
                    <td>{{ Str::limit($p->subjek, 50) }}</td>
                    <td class="small">{{ $p->telepon ?? '-' }}</td>
                    <td>
                        @if(!$p->is_read)
                        <span class="badge bg-danger">Baru</span>
                        @else
                        <span class="badge bg-secondary">Dibaca</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $p->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('admin.pesan.show', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <form method="POST" action="{{ route('admin.pesan.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada pesan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $pesan->links() }}</div>
</div>
@endsection
