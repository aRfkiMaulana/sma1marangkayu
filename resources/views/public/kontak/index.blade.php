@extends('layouts.public')
@section('title', 'Kontak - SMA Negeri 1 Marangkayu')

@section('content')

<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        @if(session('success'))
        <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 mb-8">
            <i class="fa-solid fa-circle-check mt-0.5 text-green-500"></i>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid lg:grid-cols-5 gap-8">
            {{-- INFO KONTAK --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="rounded-4xl p-6 text-white" style="background:var(--color-primary)">
                    <h2 class="font-bold text-lg mb-6">Informasi Kontak</h2>
                    <ul class="space-y-5">
                        <li class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-sm"
                                 style="background-color: rgba(255,255,255,0.15)">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-xs text-white/60 mb-1">Alamat</p>
                                <p class="text-sm text-white/90">{{ $profil->alamat ?? 'Jl. Poros Samarinda - Bontang, Marangkayu' }}</p>
                                <p class="text-sm text-white/70">{{ $profil->kabupaten ?? 'Kutai Kartanegara' }}, {{ $profil->provinsi ?? 'Kalimantan Timur' }}</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-sm"
                                 style="background-color: rgba(255,255,255,0.15)">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <p class="text-xs text-white/60 mb-1">Telepon</p>
                                <p class="text-sm text-white/90">{{ $profil->telepon ?? '-' }}</p>
                            </div>
                        </li>
                        @if($profil && $profil->whatsapp)
                        <li class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-sm bg-green-500">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="text-xs text-white/60 mb-1">WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/\D/','',$profil->whatsapp) }}"
                                   target="_blank" class="text-sm text-white/90 hover:text-yellow-400 transition-colors">
                                    {{ $profil->whatsapp }}
                                </a>
                            </div>
                        </li>
                        @endif
                        <li class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 text-sm"
                                 style="background-color: rgba(255,255,255,0.15)">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <p class="text-xs text-white/60 mb-1">Email</p>
                                <p class="text-sm text-white/90">{{ $profil->email ?? 'sman1marangkayu@gmail.com' }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- FORM --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-4xl border-3 border--300 p-8">
                    <h2 class="font-bold text-lg mb-6" style="color: var(--color-primary)">Kirim Pesan</h2>
                    <form method="POST" action="{{ route('kontak.kirim') }}" class="space-y-4">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama"
                                       class="form-input @error('nama') ring-1 ring-red-400 border-red-400 @enderror"
                                       value="{{ old('nama') }}" placeholder="Nama Anda" required>
                                @error('nama')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email"
                                       class="form-input @error('email') ring-1 ring-red-400 border-red-400 @enderror"
                                       value="{{ old('email') }}" placeholder="email@example.com" required>
                                @error('email')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="telepon" class="form-input"
                                       value="{{ old('telepon') }}" placeholder="08xx-xxxx-xxxx">
                            </div>
                            <div>
                                <label class="form-label">Subjek <span class="text-red-500">*</span></label>
                                <input type="text" name="subjek"
                                       class="form-input @error('subjek') ring-1 ring-red-400 border-red-400 @enderror"
                                       value="{{ old('subjek') }}" placeholder="Perihal pesan" required>
                                @error('subjek')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Pesan <span class="text-red-500">*</span></label>
                            <textarea name="pesan" rows="5"
                                      class="form-input @error('pesan') ring-1 ring-red-400 border-red-400 @enderror"
                                      placeholder="Tulis pesan Anda..." required>{{ old('pesan') }}</textarea>
                            @error('pesan')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center py-3">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            {{-- MAPS --}}
            @if($profil && $profil->maps_embed)
            <div class="lg:col-span-5">
                <h2 class="font-bold text-lg mb-4" style="color: var(--color-primary)">Lokasi Sekolah</h2>
                <div class="rounded-2xl overflow-hidden shadow-sm">
                    {!! $profil->maps_embed !!}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
