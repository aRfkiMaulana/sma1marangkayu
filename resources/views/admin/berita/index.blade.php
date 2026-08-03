@extends('admin.layouts.app')
@section('title', 'Kelola Berita')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div></div>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Berita</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Judul</th><th>Tipe</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($berita as $b)
                <tr>
                    <td>{{ Str::limit($b->judul, 55) }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($b->tipe) }}</span></td>
                    <td>{{ $b->kategori->nama ?? '-' }}</td>
                    <td>
                        @if($b->status === 'published')
                        <span class="badge bg-success">Published</span>
                        @else
                        <span class="badge bg-secondary">Draft</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $b->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.berita.edit', $b) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.berita.destroy', $b) }}" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $berita->links() }}</div>
</div>
@endsection
