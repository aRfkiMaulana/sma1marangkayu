@extends('layouts.public')
@section('title', 'Form Pengisian Buku Tahunan')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-6 md:p-8">
        <div class="mb-6 border-b border-slate-100 pb-4">
            <h1 class="text-xl font-bold text-gray-800">Form Pengisian Buku Tahunan</h1>
            <p class="text-sm text-gray-500">Halo <strong>{{ $siswa->nama }}</strong> ({{ $siswa->angkatan->nama_angkatan }}), silakan masukan foto diri terbaik dan moto kamu.</p>
        </div>

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 text-xs p-4 rounded-xl mb-6">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('buku-tahunan.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input type="hidden" name="nisn" value="{{ $siswa->nisn }}">
            <input type="hidden" name="kode_unik" value="{{ $siswa->kode_unik }}">

            <div>
                <label class="form-label">Upload Foto Formal / Kasual Resmi <span class="text-red-500">*</span></label>
                <input type="file" name="foto" class="form-input" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP (Max 2MB). Otomatis dikompres ke WebP.</p>
                @error('foto')<p class="form-error mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">Moto Hidup / Kesan Pesan <span class="text-red-500">*</span></label>
                <textarea name="moto" rows="4" class="form-input" placeholder="Tuliskan moto hidup atau pesan selama di sekolah..." required>{{ old('moto') }}</textarea>
                @error('moto')<p class="form-error mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">Verifikasi Keamanan (CAPTCHA) <span class="text-red-500">*</span></label>
                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                @error('cf-turnstile-response')<p class="form-error mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-4 flex gap-3">
                <a href="{{ route('buku-tahunan.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-paper-plane"></i> Submit Data Buku Tahunan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endsection
