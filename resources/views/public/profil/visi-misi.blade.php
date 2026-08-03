@extends('layouts.public')
@section('title', 'Visi & Misi - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Visi &amp; Misi</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-5">Visi &amp; Misi</h2>
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="p-4 rounded-3 h-100" style="background:var(--primary);color:#fff">
                    <i class="bi bi-eye fs-2 mb-3" style="color:var(--secondary)"></i>
                    <h4 class="fw-bold mb-3" style="color:var(--secondary)">VISI</h4>
                    <p class="mb-0" style="line-height:1.9">{{ $profil->visi ?? 'Belum diisi.' }}</p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="p-4 rounded-3 h-100" style="background:var(--light-bg)">
                    <i class="bi bi-list-check fs-2 mb-3" style="color:var(--primary)"></i>
                    <h4 class="fw-bold mb-3" style="color:var(--primary)">MISI</h4>
                    <div style="white-space:pre-line;line-height:1.9">{{ $profil->misi ?? 'Belum diisi.' }}</div>
                </div>
            </div>
            @if($profil && $profil->tujuan)
            <div class="col-12" data-aos="fade-up">
                <div class="p-4 rounded-3" style="background:var(--light-bg)">
                    <h5 class="fw-bold mb-3" style="color:var(--primary)"><i class="bi bi-bullseye me-2"></i>TUJUAN</h5>
                    <div style="white-space:pre-line;line-height:1.9">{{ $profil->tujuan }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
