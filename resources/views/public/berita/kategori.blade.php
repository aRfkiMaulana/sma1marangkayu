@extends('layouts.public')
@section('title', 'Kategori: ' . $kategori->nama . ' - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                <li class="breadcrumb-item active">{{ $kategori->nama }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <h4 class="section-title mb-4">Kategori: {{ $kategori->nama }}</h4>
        <div class="row g-4">
            @forelse($berita as $b)
            <div class="col-md-4">
                <div class="card card-berita h-100">
                    <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/600x350/1a3d6e/fff?text=Berita' }}"
                         class="card-img-top" alt="{{ $b->judul }}">
                    <div class="card-body">
                        <h6><a href="{{ route('berita.show', $b->slug) }}" class="text-dark text-decoration-none stretched-link">{{ Str::limit($b->judul, 65) }}</a></h6>
                        <p class="small text-muted">{{ Str::limit(strip_tags($b->konten), 90) }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted text-center py-5">Belum ada berita dalam kategori ini.</div>
            @endforelse
        </div>
        <div class="mt-4">{{ $berita->links() }}</div>
    </div>
</section>
@endsection
