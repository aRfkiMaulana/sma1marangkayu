@extends('admin.layouts.app')
@section('title', 'Kelola Galeri')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Item</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Foto</th><th>Judul</th><th>Tipe</th><th>Album</th><th>Highlight</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($galeri as $g)
                <tr>
                    <td><img src="{{ $g->tipe === 'foto' ? Storage::url($g->file) : 'https://placehold.co/60x45/1a3d6e/fff?text=Video' }}" height="45" class="rounded" alt=""></td>
                    <td>{{ Str::limit($g->judul, 50) }}</td>
                    <td><span class="badge {{ $g->tipe === 'foto' ? 'bg-info' : 'bg-danger' }}">{{ ucfirst($g->tipe) }}</span></td>
                    <td>{{ $g->album ?? '-' }}</td>
                    <td>{!! $g->is_highlight ? '<i class="bi bi-star-fill text-warning"></i>' : '-' !!}</td>
                    <td>
                        <a href="{{ route('admin.galeri.edit', $g) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.galeri.destroy', $g) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Galeri kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $galeri->links() }}</div>
</div>
@endsection
