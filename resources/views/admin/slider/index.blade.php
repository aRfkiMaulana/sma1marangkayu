@extends('admin.layouts.app')
@section('title', 'Kelola Slider')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Slider</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Gambar</th><th>Judul</th><th>Subjudul</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($sliders as $s)
                <tr>
                    <td><img src="{{ Storage::url($s->gambar) }}" height="48" style="width:80px;object-fit:cover" class="rounded" alt="" onerror="this.src='https://placehold.co/80x48/1a3d6e/fff?text=Slider'"></td>
                    <td>{{ $s->judul ?? '-' }}</td><td>{{ Str::limit($s->subjudul, 40) ?? '-' }}</td>
                    <td>{{ $s->urutan }}</td>
                    <td>{!! $s->is_aktif ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' !!}</td>
                    <td>
                        <a href="{{ route('admin.slider.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.slider.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada slider.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
