@extends('layouts.public')
@section('title', 'Beranda - SMA Negeri 1 Marangkayu')

@section('content')

{{-- HERO SLIDER --}}
<div id="heroSlider" class="carousel slide hero-slider" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach($sliders as $i => $s)
        <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @forelse($sliders as $i => $slider)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <img src="{{ Storage::url($slider->gambar) }}" class="d-block w-100" alt="{{ $slider->judul }}"
                 onerror="this.src='https://placehold.co/1400x520/1a3d6e/fff?text=SMA+Negeri+1+Marangkayu'">
            <div class="carousel-caption d-none d-md-block">
                @if($slider->judul)
                <h2 data-aos="fade-up">{{ $slider->judul }}</h2>
                @endif
                @if($slider->subjudul)
                <p data-aos="fade-up" data-aos-delay="100">{{ $slider->subjudul }}</p>
                @endif
            </div>
        </div>
        @empty
        <div class="carousel-item active">
            <img src="https://placehold.co/1400x520/1a3d6e/fff?text=SMA+Negeri+1+Marangkayu" class="d-block w-100" alt="SMA Negeri 1 Marangkayu">
            <div class="carousel-caption d-none d-md-block">
                <h2>Selamat Datang di SMA Negeri 1 Marangkayu</h2>
                <p>Unggul dalam Prestasi, Mulia dalam Akhlak</p>
            </div>
        </div>
        @endforelse
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

{{-- STATISTIK --}}
<section class="py-5" style="background:var(--light-bg)">
    <div class="container">
        <div class="row g-4 justify-content-center text-center">
            <div class="col-6 col-md-3" data-aos="fade-up">
                <div class="stat-box rounded-3">
                    <div class="stat-num">{{ $profil->jumlah_siswa ?? 600 }}</div>
                    <div class="small mt-1"><i class="bi bi-people me-1"></i>Siswa Aktif</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-box rounded-3">
                    <div class="stat-num">{{ $profil->jumlah_guru ?? 45 }}</div>
                    <div class="small mt-1"><i class="bi bi-person-badge me-1"></i>Tenaga Pendidik</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-box rounded-3">
                    <div class="stat-num">{{ $prestasi->count() }}+</div>
                    <div class="small mt-1"><i class="bi bi-trophy me-1"></i>Prestasi</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-box rounded-3">
                    <div class="stat-num">{{ $profil->tahun_berdiri ? (date('Y') - $profil->tahun_berdiri) : 30 }}+</div>
                    <div class="small mt-1"><i class="bi bi-calendar-check me-1"></i>Tahun Berdiri</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Berita &amp; Pengumuman</h2>
            <a href="{{ route('berita.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-4">
            @forelse($berita as $b)
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="card card-berita h-100">
                    <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/600x350/1a3d6e/fff?text=Berita' }}"
                         class="card-img-top" alt="{{ $b->judul }}">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary badge-tipe">{{ ucfirst($b->tipe) }}</span>
                            @if($b->kategori)
                            <span class="badge bg-secondary badge-tipe">{{ $b->kategori->nama }}</span>
                            @endif
                        </div>
                        <h6 class="card-title fw-600">
                            <a href="{{ route('berita.show', $b->slug) }}" class="text-dark text-decoration-none stretched-link">
                                {{ Str::limit($b->judul, 65) }}
                            </a>
                        </h6>
                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($b->ringkasan ?? strip_tags($b->konten), 100) }}</p>
                        <div class="mt-auto text-muted small">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $b->tanggal_publish ? $b->tanggal_publish->translatedFormat('d M Y') : $b->created_at->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-4">Belum ada berita tersedia.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- GALERI HIGHLIGHT --}}
@if($galeri->count())
<section class="py-5" style="background:var(--light-bg)">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Galeri</h2>
            <a href="{{ route('galeri.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row g-3">
            @foreach($galeri as $g)
            <div class="col-6 col-md-3" data-aos="zoom-in">
                <div class="galeri-item">
                    <img src="{{ $g->tipe === 'foto' ? Storage::url($g->file) : 'https://placehold.co/400x300/1a3d6e/fff?text=Video' }}"
                         alt="{{ $g->judul }}" class="img-fluid rounded">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- VISI MISI SINGKAT --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5" data-aos="fade-right">
                <h2 class="section-title mb-3">Visi &amp; Misi</h2>
                @if($profil && $profil->visi)
                <h6 class="fw-bold text-primary-custom mt-4">VISI</h6>
                <p>{{ $profil->visi }}</p>
                @endif
                <a href="{{ route('profil.visi-misi') }}" class="btn btn-primary-custom btn-sm mt-2">
                    Selengkapnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="p-4 rounded-3" style="background:var(--light-bg)">
                    <h6 class="fw-bold text-primary-custom"><i class="bi bi-check2-circle me-2 text-success"></i>MISI</h6>
                    @if($profil && $profil->misi)
                    <div class="small mt-2" style="white-space:pre-line">{{ $profil->misi }}</div>
                    @else
                    <p class="text-muted small">Misi sekolah belum diisi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
