@extends('admin.layouts.app')
@section('title', 'Detail Pesan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6"><strong>Nama:</strong> {{ $pesan->nama }}</div>
            <div class="col-md-6"><strong>Email:</strong> <a href="mailto:{{ $pesan->email }}">{{ $pesan->email }}</a></div>
            <div class="col-md-6"><strong>Telepon:</strong> {{ $pesan->telepon ?? '-' }}</div>
            <div class="col-md-6"><strong>Waktu:</strong> {{ $pesan->created_at->translatedFormat('d F Y, H:i') }}</div>
            <div class="col-12"><strong>Subjek:</strong> {{ $pesan->subjek }}</div>
            <div class="col-12">
                <strong>Pesan:</strong>
                <div class="mt-2 p-3 rounded" style="background:#f8f9fa;white-space:pre-line">{{ $pesan->pesan }}</div>
            </div>
            <div class="col-12 d-flex gap-2 mt-2">
                <a href="mailto:{{ $pesan->email }}?subject=Re: {{ $pesan->subjek }}" class="btn btn-primary">
                    <i class="bi bi-reply me-2"></i>Balas via Email
                </a>
                <a href="{{ route('admin.pesan.index') }}" class="btn btn-outline-secondary">Kembali</a>
                <form method="POST" action="{{ route('admin.pesan.destroy', $pesan) }}" class="ms-auto" onsubmit="return confirm('Hapus pesan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
