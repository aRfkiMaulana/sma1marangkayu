@extends('layouts.public')
@section('title', 'Guru & Staf - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Guru &amp; Staf</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-2">Tenaga Pendidik</h2>
        <p class="text-muted mb-4">Daftar guru dan staf SMA Negeri 1 Marangkayu</p>

        <h5 class="fw-bold text-primary-custom mb-3"><i class="bi bi-person-badge me-2"></i>Guru</h5>
        <div class="row g-4 mb-5">
            @forelse($guru as $g)
            <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up">
                <div class="text-center">
                    <img src="{{ $g->foto ? Storage::url($g->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($g->nama) . '&background=1a3d6e&color=fff&size=100' }}"
                         class="rounded-circle mb-2" style="width:90px;height:90px;object-fit:cover" alt="{{ $g->nama }}">
                    <div class="fw-600 small">{{ $g->nama }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $g->jabatan ?? $g->mata_pelajaran }}</div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted text-center">Data guru belum tersedia.</div>
            @endforelse
        </div>

        <h5 class="fw-bold text-primary-custom mb-3"><i class="bi bi-people me-2"></i>Staf / Tata Usaha</h5>
        <div class="row g-4">
            @forelse($staf as $s)
            <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up">
                <div class="text-center">
                    <img src="{{ $s->foto ? Storage::url($s->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($s->nama) . '&background=e8a020&color=fff&size=100' }}"
                         class="rounded-circle mb-2" style="width:90px;height:90px;object-fit:cover" alt="{{ $s->nama }}">
                    <div class="fw-600 small">{{ $s->nama }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $s->jabatan }}</div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted text-center">Data staf belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
