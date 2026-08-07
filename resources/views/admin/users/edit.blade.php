@extends('admin.layouts.app')
@section('title', 'Edit Pengelola CMS')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Edit Pengelola CMS</h1>
        <p class="text-sm text-gray-500">Perbarui informasi akun pengelola atau ganti password</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-2xl">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="form-label">Nama Lengkap Pengelola <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="form-input @error('name') border-red-400 @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')<p class="form-error mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Email Address <span class="text-red-500">*</span></label>
            <input type="email" name="email" class="form-input @error('email') border-red-400 @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')<p class="form-error mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-xs text-blue-700">
            <i class="fa-solid fa-circle-info mr-1"></i> Biarkan kolom password kosong jika tidak ingin mengubah password akun pengelola ini.
        </div>

        <div>
            <label class="form-label">Password Baru (Opsional)</label>
            <input type="password" name="password" class="form-input @error('password') border-red-400 @enderror">
            @error('password')<p class="form-error mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Ulangi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-input">
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Update Pengelola
            </button>
        </div>
    </form>
</div>
@endsection
