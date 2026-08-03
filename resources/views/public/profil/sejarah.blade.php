@extends('layouts.public')
@section('title', 'Sejarah Sekolah - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Profil</a></li>
            <li class="breadcrumb-item active">Sejarah Sekolah</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h2 class="section-title mb-4">Sejarah SMA Negeri 1 Marangkayu</h2>
                @if($profil && $profil->sejarah)
                <div style="line-height:1.9">{!! nl2br(e($profil->sejarah)) !!}</div>
                @else
                <p class="text-muted">Informasi sejarah sekolah belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
