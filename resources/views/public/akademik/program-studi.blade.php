@extends('layouts.public')
@section('title', 'Program Studi - SMA Negeri 1 Marangkayu')
@section('content')
<div class="breadcrumb-section py-3"><div class="container">
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item active">Program Studi</li>
    </ol></nav>
</div></div>
<section class="py-5"><div class="container">
    <h2 class="section-title mb-4">Program Studi / Jurusan</h2>
    @forelse($data as $d)
    <div class="card border-0 shadow-sm mb-3 p-4"><h5 class="fw-bold">{{ $d->judul }}</h5><div>{!! $d->konten !!}</div></div>
    @empty
    <p class="text-muted">Informasi program studi belum tersedia.</p>
    @endforelse
</div></section>
@endsection
