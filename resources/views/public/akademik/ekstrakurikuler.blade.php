@extends('layouts.public')
@section('title', 'Ekstrakurikuler - SMA Negeri 1 Marangkayu')
@section('content')
<div class="breadcrumb-section py-3"><div class="container">
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item active">Ekstrakurikuler</li>
    </ol></nav>
</div></div>
<section class="py-5"><div class="container">
    <h2 class="section-title mb-4">Ekstrakurikuler</h2>
    <div class="row g-4">
        @forelse($ekskul as $e)
        <div class="col-md-4 col-lg-3" data-aos="fade-up">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ $e->foto ? Storage::url($e->foto) : 'https://placehold.co/400x260/1a3d6e/fff?text=' . urlencode($e->nama) }}"
                     class="card-img-top" style="height:160px;object-fit:cover" alt="{{ $e->nama }}">
                <div class="card-body">
                    <h6 class="fw-bold">{{ $e->nama }}</h6>
                    @if($e->pembina)<p class="small text-muted mb-1"><i class="bi bi-person me-1"></i>{{ $e->pembina }}</p>@endif
                    @if($e->jadwal)<p class="small text-muted"><i class="bi bi-clock me-1"></i>{{ $e->jadwal }}</p>@endif
                    @if($e->deskripsi)<p class="small">{{ Str::limit($e->deskripsi, 80) }}</p>@endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-muted text-center py-5">Data ekstrakurikuler belum tersedia.</div>
        @endforelse
    </div>
</div></section>
@endsection
