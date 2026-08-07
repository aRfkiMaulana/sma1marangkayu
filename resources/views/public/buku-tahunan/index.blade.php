@extends('layouts.public')
@section('title', 'Buku Tahunan Siswa')

@section('content')
<div class="bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white py-16 px-6">
    <div class="max-w-6xl mx-auto text-center">
        <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Buku Tahunan Siswa</h1>
        <p class="text-slate-300 max-w-2xl mx-auto text-sm md:text-base">Kenangan dan moto alumni SMAN 1 Marangkayu. Masukkan NISN dan Kode Unik jika kamu ingin mengisi foto dan moto kamu.</p>

        {{-- FORM VERIFIKASI NISN + KODE UNIK --}}
        <div class="mt-8 max-w-xl mx-auto bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-left">
            <h2 class="text-lg font-bold text-white mb-2 flex items-center gap-2">
                <i class="fa-solid fa-key text-amber-400"></i> Form Siswa — Isi Foto & Moto
            </h2>
            <p class="text-xs text-slate-300 mb-4">Minta Kode Unik kepada Wali Kelas kamu untuk mengakses form pengisian.</p>

            @if(session('error'))
            <div class="bg-red-500/20 border border-red-500/50 text-red-200 text-xs p-3 rounded-xl mb-4">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('buku-tahunan.verify') }}" method="POST" class="grid sm:grid-cols-2 gap-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-200 mb-1">NISN Siswa</label>
                    <input type="text" name="nisn" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400" placeholder="Masukkan NISN" required value="{{ old('nisn') }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-200 mb-1">Kode Unik</label>
                    <input type="text" name="kode_unik" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 font-mono tracking-widest uppercase" placeholder="KODE UNIK" required value="{{ old('kode_unik') }}">
                </div>
                <div class="sm:col-span-2 pt-2">
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2.5 rounded-xl text-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i> Verifikasi &amp; Isi Form
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto py-12 px-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <h2 class="text-xl font-bold text-gray-800">Daftar Alumni & Siswa Approved</h2>
        <form action="{{ route('buku-tahunan.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <select name="angkatan_id" class="form-input text-xs w-48" onchange="this.form.submit()">
                <option value="">Semua Angkatan</option>
                @foreach($angkatans as $a)
                <option value="{{ $a->id }}" {{ request('angkatan_id') == $a->id ? 'selected' : '' }}>{{ $a->nama_angkatan }} ({{ $a->tahun_lulus }})</option>
                @endforeach
            </select>
            <input type="text" name="search" class="form-input text-xs w-48" placeholder="Cari nama..." value="{{ request('search') }}">
        </form>
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($siswas as $s)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition">
            <div class="relative">
                <img src="{{ Storage::url($s->foto) }}" class="w-full h-64 object-cover object-top" alt="{{ $s->nama }}">
                <div class="absolute bottom-2 left-2 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-lg text-white text-xs font-semibold">
                    {{ $s->angkatan->nama_angkatan }}
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gray-900 text-base mb-1">{{ $s->nama }}</h3>
                    <p class="text-xs text-gray-500 italic mb-3">"{{ $s->moto }}"</p>
                </div>
                <div class="text-xs text-slate-400 font-mono">Tahun Lulus: {{ $s->angkatan->tahun_lulus }}</div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-400">
            Belum ada data buku tahunan yang disetujui (Approved) untuk ditampilkan.
        </div>
        @endforelse
    </div>

    @if($siswas->hasPages())
    <div class="mt-8">
        {{ $siswas->links() }}
    </div>
    @endif
</div>
@endsection
