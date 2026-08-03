@extends('layouts.public')
@section('title', 'Fasilitas - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Fasilitas</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-4">Fasilitas Sekolah</h2>
        <div class="row g-4">
            @forelse($fasilitas as $f)
            <div class="col-md-4 col-lg-3" data-aos="fade-up">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ $f->foto ? Storage::url($f->foto) : 'https://placehold.co/400x260/1a3d6e/fff?text=' . urlencode($f->nama) }}"
                         class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $f->nama }}">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $f->nama }}</h6>
                        @if($f->deskripsi)<p class="small text-muted">{{ Str::limit($f->deskripsi, 80) }}</p>@endif
                        @if($f->jumlah > 1)<span class="badge bg-primary">Jumlah: {{ $f->jumlah }}</span>@endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted text-center py-5">Data fasilitas belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
