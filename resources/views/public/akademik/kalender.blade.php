@extends('layouts.public')
@section('title', 'Kalender Akademik - SMA Negeri 1 Marangkayu')
@section('content')
<div class="breadcrumb-section py-3"><div class="container">
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item active">Kalender Akademik</li>
    </ol></nav>
</div></div>
<section class="py-5"><div class="container">
    <h2 class="section-title mb-4">Kalender Akademik</h2>
    @if($data)
    <div style="line-height:1.9">{!! $data->konten !!}</div>
    @if($data->file_lampiran)
    <a href="{{ Storage::url($data->file_lampiran) }}" class="btn btn-primary-custom mt-3" target="_blank"><i class="bi bi-download me-2"></i>Unduh Kalender</a>
    @endif
    @else
    <p class="text-muted">Kalender akademik belum tersedia.</p>
    @endif
</div></section>
@endsection
