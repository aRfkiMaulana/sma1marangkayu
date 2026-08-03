@extends('layouts.public')
@section('title', 'Album: ' . $album . ' - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active">{{ $album }}</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-4">Album: {{ $album }}</h2>
        <div class="row g-3">
            @forelse($galeri as $g)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="galeri-item">
                    <img src="{{ $g->tipe === 'foto' ? Storage::url($g->file) : 'https://placehold.co/400x300/1a3d6e/fff?text=Video' }}"
                         class="img-fluid rounded w-100" style="height:200px;object-fit:cover" alt="{{ $g->judul }}">
                    <div class="mt-1 small text-muted">{{ Str::limit($g->judul, 40) }}</div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-5">Album kosong.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
