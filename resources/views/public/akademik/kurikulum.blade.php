@extends('layouts.public')
@section('title', 'Kurikulum - SMA Negeri 1 Marangkayu')
@section('content')
<div class="breadcrumb-section py-3"><div class="container">
    <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item active">Kurikulum</li>
    </ol></nav>
</div></div>
<section class="py-5"><div class="container">
    <h2 class="section-title mb-4">Kurikulum</h2>
    @if($data)
    <div style="line-height:1.9">{!! $data->konten !!}</div>
    @else
    <p class="text-muted">Informasi kurikulum belum tersedia.</p>
    @endif
</div></section>
@endsection
