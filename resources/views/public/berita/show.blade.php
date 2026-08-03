@extends('layouts.public')
@section('title', $berita->judul . ' - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width:300px">{{ $berita->judul }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                @if($berita->thumbnail)
                <img src="{{ Storage::url($berita->thumbnail) }}" class="img-fluid rounded mb-4 w-100" style="max-height:420px;object-fit:cover" alt="{{ $berita->judul }}">
                @endif
                <div class="mb-2">
                    <span class="badge bg-primary badge-tipe">{{ ucfirst($berita->tipe) }}</span>
                    @if($berita->kategori)
                    <span class="badge bg-secondary badge-tipe">{{ $berita->kategori->nama }}</span>
                    @endif
                </div>
                <h2 class="fw-bold mb-2">{{ $berita->judul }}</h2>
                <div class="text-muted small mb-4">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ optional($berita->tanggal_publish)->translatedFormat('d F Y') ?? $berita->created_at->translatedFormat('d F Y') }}
                    <span class="mx-2">|</span>
                    <i class="bi bi-eye me-1"></i>{{ number_format($berita->views) }} dilihat
                </div>
                <div class="content-body" style="line-height:1.9">
                    {!! $berita->konten !!}
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary-custom text-white fw-600">Berita Terkait</div>
                    <div class="list-group list-group-flush">
                        @forelse($related as $r)
                        <a href="{{ route('berita.show', $r->slug) }}" class="list-group-item list-group-item-action px-3 py-2">
                            <div class="d-flex gap-2">
                                <img src="{{ $r->thumbnail ? Storage::url($r->thumbnail) : 'https://placehold.co/80x60/1a3d6e/fff?text=Berita' }}"
                                     style="width:70px;height:52px;object-fit:cover;border-radius:6px" alt="">
                                <div>
                                    <div class="small fw-500">{{ Str::limit($r->judul, 55) }}</div>
                                    <div class="text-muted" style="font-size:.72rem">{{ optional($r->tanggal_publish)->translatedFormat('d M Y') }}</div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="list-group-item text-muted small">Tidak ada berita terkait.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
