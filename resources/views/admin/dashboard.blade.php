@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="icon" style="background:#dbeafe"><i class="bi bi-newspaper text-primary"></i></div>
            <div><div class="fw-bold fs-5">{{ $stats['berita'] }}</div><div class="small text-muted">Berita</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="icon" style="background:#d1fae5"><i class="bi bi-image text-success"></i></div>
            <div><div class="fw-bold fs-5">{{ $stats['galeri'] }}</div><div class="small text-muted">Galeri</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="icon" style="background:#fef3c7"><i class="bi bi-person-badge" style="color:#d97706"></i></div>
            <div><div class="fw-bold fs-5">{{ $stats['guru'] }}</div><div class="small text-muted">Guru</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="icon" style="background:#fce7f3"><i class="bi bi-envelope text-danger"></i></div>
            <div><div class="fw-bold fs-5">{{ $stats['pesan_baru'] }}</div><div class="small text-muted">Pesan Baru</div></div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- BERITA TERBARU --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-600">Berita Terbaru</span>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light"><tr><th>Judul</th><th>Tipe</th><th>Status</th><th>Tanggal</th></tr></thead>
                    <tbody>
                        @forelse($berita_terbaru as $b)
                        <tr>
                            <td><a href="{{ route('admin.berita.edit', $b) }}" class="text-decoration-none">{{ Str::limit($b->judul, 45) }}</a></td>
                            <td><span class="badge bg-info">{{ ucfirst($b->tipe) }}</span></td>
                            <td>
                                @if($b->status === 'published')
                                <span class="badge bg-success">Published</span>
                                @else
                                <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $b->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada berita.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PESAN TERBARU --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-600">Pesan Masuk</span>
                <a href="{{ route('admin.pesan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($pesan_terbaru as $p)
                <a href="{{ route('admin.pesan.show', $p) }}" class="list-group-item list-group-item-action px-3 py-2 {{ !$p->is_read ? 'fw-600' : '' }}">
                    <div class="d-flex justify-content-between">
                        <span class="small">{{ $p->nama }}</span>
                        <span class="text-muted" style="font-size:.72rem">{{ $p->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="small text-muted">{{ Str::limit($p->subjek, 45) }}</div>
                </a>
                @empty
                <div class="list-group-item text-muted small text-center py-3">Belum ada pesan.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
