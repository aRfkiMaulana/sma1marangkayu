@extends('layouts.public')
@section('title', 'Prestasi - SMA Negeri 1 Marangkayu')
@section('content')
<div class="breadcrumb-section py-3"><div class="container">
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item active">Prestasi</li>
    </ol></nav>
</div></div>
<section class="py-5"><div class="container">
    <h2 class="section-title mb-4">Prestasi Sekolah</h2>
    <div class="row g-4">
        @forelse($prestasi as $p)
        <div class="col-md-4" data-aos="fade-up">
            <div class="card border-0 shadow-sm h-100">
                @if($p->foto)
                <img src="{{ Storage::url($p->foto) }}" class="card-img-top" style="height:160px;object-fit:cover" alt="{{ $p->judul }}">
                @endif
                <div class="card-body">
                    <span class="badge mb-2" style="background:var(--secondary)">{{ ucfirst($p->tingkat) }}</span>
                    <span class="badge bg-info mb-2">{{ ucfirst(str_replace('_', ' ', $p->kategori)) }}</span>
                    <h6 class="fw-bold">{{ $p->judul }}</h6>
                    @if($p->peraih)<p class="small text-muted mb-1"><i class="bi bi-person me-1"></i>{{ $p->peraih }}</p>@endif
                    <p class="small text-muted"><i class="bi bi-calendar me-1"></i>{{ $p->tahun }}</p>
                    @if($p->deskripsi)<p class="small">{{ Str::limit($p->deskripsi, 80) }}</p>@endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-muted text-center py-5">Data prestasi belum tersedia.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $prestasi->links() }}</div>
</div></section>
@endsection
