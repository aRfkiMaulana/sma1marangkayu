@extends('admin.layouts.app')
@section('title', 'Kelola Fasilitas')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Fasilitas</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($fasilitas as $f)
                <tr>
                    <td><img src="{{ $f->foto ? Storage::url($f->foto) : 'https://placehold.co/50x38/1a3d6e/fff?text=F' }}" height="38" class="rounded" alt=""></td>
                    <td>{{ $f->nama }}</td><td>{{ $f->kategori ?? '-' }}</td><td>{{ $f->jumlah }}</td>
                    <td>{!! $f->is_aktif ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' !!}</td>
                    <td>
                        <a href="{{ route('admin.fasilitas.edit', $f) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.fasilitas.destroy', $f) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada fasilitas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $fasilitas->links() }}</div>
</div>
@endsection
