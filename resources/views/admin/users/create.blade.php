@extends('admin.layouts.app')
@section('title', 'Tambah Pengelola CMS')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Tambah Pengelola CMS</h1>
        <p class="text-sm text-gray-500">Buat akun administrator baru untuk pengelolaan website sekolah</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-2xl">
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="form-label">Nama Lengkap Pengelola <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="form-input @error('name') border-red-400 @enderror" value="{{ old('name') }}" required>
            @error('name')<p class="form-error mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Email Address <span class="text-red-500">*</span></label>
            <input type="email" name="email" class="form-input @error('email') border-red-400 @enderror" value="{{ old('email') }}" required>
            @error('email')<p class="form-error mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Password <span class="text-red-500">*</span></label>
            <input type="password" name="password" class="form-input @error('password') border-red-400 @enderror" required>
            @error('password')<p class="form-error mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
            <input type="password" name="password_confirmation" class="form-input" required>
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Pengelola
            </button>
        </div>
    </form>
</div>
@endsection
