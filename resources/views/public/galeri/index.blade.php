@extends('layouts.public')
@section('title', 'Galeri - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Galeri</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-4">Galeri Foto &amp; Video</h2>

        @if($album->count())
        <div class="mb-4 d-flex flex-wrap gap-2">
            <a href="{{ route('galeri.index') }}" class="btn btn-sm btn-primary-custom">Semua</a>
            @foreach($album as $a)
            <a href="{{ route('galeri.album', $a) }}" class="btn btn-sm btn-outline-primary">{{ $a }}</a>
            @endforeach
        </div>
        @endif

        <div class="row g-3">
            @forelse($galeri as $g)
            <div class="col-6 col-md-4 col-lg-3" data-aos="zoom-in">
                <div class="galeri-item position-relative">
                    @if($g->tipe === 'foto')
                    <img src="{{ Storage::url($g->file) }}" class="img-fluid rounded w-100" style="height:200px;object-fit:cover" alt="{{ $g->judul }}">
                    @else
                    <div class="position-relative">
                        <img src="https://placehold.co/400x300/1a3d6e/fff?text=Video" class="img-fluid rounded w-100" style="height:200px;object-fit:cover" alt="{{ $g->judul }}">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-play-circle-fill text-white fs-1"></i>
                        </div>
                    </div>
                    @endif
                    <div class="mt-1 small text-muted">{{ Str::limit($g->judul, 40) }}</div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted text-center py-5">Galeri masih kosong.</div>
            @endforelse
        </div>
        <div class="mt-4">{{ $galeri->links() }}</div>
    </div>
</section>
@endsection
