@extends('layouts.public')
@section('title', 'Kontak - SMA Negeri 1 Marangkayu')

@section('content')
<div class="breadcrumb-section py-3">
    <div class="container">
        <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Kontak</li>
        </ol></nav>
    </div>
</div>
<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-4">Hubungi Kami</h2>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row g-5">
            {{-- INFO KONTAK --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h5 class="fw-bold mb-4 text-primary-custom">Informasi Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex gap-3">
                            <i class="bi bi-geo-alt-fill text-primary-custom fs-5"></i>
                            <div>
                                <strong>Alamat</strong><br>
                                <span class="text-muted small">{{ $profil->alamat ?? 'Jl. Poros Samarinda - Bontang, Marangkayu' }}<br>
                                {{ $profil->kabupaten ?? 'Kutai Kartanegara' }}, {{ $profil->provinsi ?? 'Kalimantan Timur' }}</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <i class="bi bi-telephone-fill text-primary-custom fs-5"></i>
                            <div>
                                <strong>Telepon</strong><br>
                                <span class="text-muted small">{{ $profil->telepon ?? '-' }}</span>
                            </div>
                        </li>
                        @if($profil && $profil->whatsapp)
                        <li class="mb-3 d-flex gap-3">
                            <i class="bi bi-whatsapp text-success fs-5"></i>
                            <div>
                                <strong>WhatsApp</strong><br>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $profil->whatsapp) }}" target="_blank" class="text-muted small">{{ $profil->whatsapp }}</a>
                            </div>
                        </li>
                        @endif
                        <li class="mb-3 d-flex gap-3">
                            <i class="bi bi-envelope-fill text-primary-custom fs-5"></i>
                            <div>
                                <strong>Email</strong><br>
                                <span class="text-muted small">{{ $profil->email ?? 'sman1marangkayu@gmail.com' }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- FORM KONTAK --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-4 text-primary-custom">Kirim Pesan</h5>
                    <form method="POST" action="{{ route('kontak.kirim') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-500">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}" placeholder="Nama Anda" required>
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-500">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="email@example.com" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-500">No. Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="08xx-xxxx-xxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-500">Subjek <span class="text-danger">*</span></label>
                                <input type="text" name="subjek" class="form-control @error('subjek') is-invalid @enderror"
                                       value="{{ old('subjek') }}" placeholder="Perihal pesan" required>
                                @error('subjek')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-500">Pesan <span class="text-danger">*</span></label>
                                <textarea name="pesan" rows="5" class="form-control @error('pesan') is-invalid @enderror"
                                          placeholder="Tulis pesan Anda..." required>{{ old('pesan') }}</textarea>
                                @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-custom px-4">
                                    <i class="bi bi-send me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- PETA --}}
            @if($profil && $profil->maps_embed)
            <div class="col-12">
                <h5 class="fw-bold mb-3 text-primary-custom">Lokasi Sekolah</h5>
                <div class="rounded-3 overflow-hidden shadow-sm">
                    {!! $profil->maps_embed !!}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
