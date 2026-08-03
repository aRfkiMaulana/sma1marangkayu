@extends('admin.layouts.app')
@section('title', 'Kelola Guru & Staf')
@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.guru-staf.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah</a>
</div>
<h5 class="fw-bold mb-3">Guru</h5>
<div class="card border-0 shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Foto</th><th>Nama</th><th>NIP</th><th>Jabatan/Mapel</th><th>Pendidikan</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($guru as $g)
                <tr>
                    <td><img src="{{ $g->foto ? Storage::url($g->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($g->nama) . '&background=1a3d6e&color=fff&size=36' }}" width="36" height="36" class="rounded-circle" alt=""></td>
                    <td>{{ $g->nama }}</td><td>{{ $g->nip ?? '-' }}</td>
                    <td>{{ $g->jabatan ?? $g->mata_pelajaran ?? '-' }}</td>
                    <td>{{ $g->pendidikan_terakhir ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.guru-staf.edit', $g) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.guru-staf.destroy', $g) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada data guru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<h5 class="fw-bold mb-3">Staf / Tata Usaha</h5>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Foto</th><th>Nama</th><th>NIP</th><th>Jabatan</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($staf as $s)
                <tr>
                    <td><img src="{{ $s->foto ? Storage::url($s->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($s->nama) . '&background=e8a020&color=fff&size=36' }}" width="36" height="36" class="rounded-circle" alt=""></td>
                    <td>{{ $s->nama }}</td><td>{{ $s->nip ?? '-' }}</td><td>{{ $s->jabatan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.guru-staf.edit', $s) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.guru-staf.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada data staf.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
