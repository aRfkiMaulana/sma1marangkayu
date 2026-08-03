@extends('layouts.public')
@section('title', 'Berita & Kegiatan - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Berita</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            {{-- DAFTAR BERITA --}}
            <div class="col-lg-8">
                <h4 class="section-title mb-4">Berita &amp; Kegiatan</h4>
                <div class="row g-4">
                    @forelse($berita as $b)
                    <div class="col-md-6">
                        <div class="card card-berita h-100">
                            <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/600x350/1a3d6e/fff?text=Berita' }}"
                                 class="card-img-top" alt="{{ $b->judul }}">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-primary badge-tipe">{{ ucfirst($b->tipe) }}</span>
                                </div>
                                <h6 class="card-title">
                                    <a href="{{ route('berita.show', $b->slug) }}" class="text-dark text-decoration-none stretched-link">
                                        {{ Str::limit($b->judul, 70) }}
                                    </a>
                                </h6>
                                <p class="card-text text-muted small flex-grow-1">{{ Str::limit(strip_tags($b->konten), 90) }}</p>
                                <div class="text-muted small mt-auto">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ optional($b->tanggal_publish)->translatedFormat('d M Y') ?? $b->created_at->translatedFormat('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-muted py-5 text-center">Belum ada berita.</div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $berita->links() }}</div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary-custom text-white fw-600">Kategori</div>
                    <div class="card-body p-2">
                        <ul class="list-group list-group-flush">
                            @foreach($kategori as $k)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
                                <a href="{{ route('berita.kategori', $k->slug) }}" class="text-decoration-none text-dark">{{ $k->nama }}</a>
                                <span class="badge bg-primary rounded-pill">{{ $k->berita_count }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary-custom text-white fw-600">Berita Terkini</div>
                    <div class="list-group list-group-flush">
                        @foreach($terkini as $t)
                        <a href="{{ route('berita.show', $t->slug) }}" class="list-group-item list-group-item-action px-3 py-2">
                            <div class="small fw-500">{{ Str::limit($t->judul, 60) }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ optional($t->tanggal_publish)->translatedFormat('d M Y') }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
