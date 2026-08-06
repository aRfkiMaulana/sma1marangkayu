@extends('layouts.public')
@section('title', 'Profil Sekolah - SMA Negeri 1 Marangkayu')

@section('content')

@include('public.profil._subnav')

<section class="py-8 pb-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- ── SIDEBAR KIRI ─────────────────────────────── --}}
            <div class="space-y-6">

                {{-- Foto Kepala Sekolah --}}
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-200">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        @if($profil && $profil->foto_sekolah)
                            <img src="{{ asset('storage/' . $profil->foto_sekolah) }}"
                                 alt="Foto Kepala Sekolah"
                                 class="w-full h-full object-cover object-top">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fa-solid fa-user text-6xl text-gray-300"></i>
                            </div>
                        @endif
                    </div>
                    <div class="relative p-5 text-center text-white overflow-hidden"
                         style="background:var(--color-primary)">
                        <div class="absolute inset-0"
                             style="background-image:url('{{ asset('images/pattern.png') }}'); background-repeat:repeat; background-position:0 0; background-size:80px;"></div>
                        <div class="absolute inset-0 bg-black/40"></div>
                        <p class="relative font-bold text-lg text-white">
                            {{ $profil->kepala_sekolah ?? 'Kepala Sekolah' }}
                        </p>
                        <p class="relative text-sm text-white/80 mt-1">
                            Kepala SMA Negeri 1 Marangkayu
                        </p>
                    </div>
                </div>

                {{-- Kontak & Informasi --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-phone-alt w-5 h-5 text-sm" style="color:var(--color-primary)"></i>
                        Kontak &amp; Informasi
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3 text-slate-600">
                            <i class="fa-solid fa-location-dot mt-0.5 shrink-0" style="color:var(--color-primary)"></i>
                            <span>{{ $profil->alamat ?? '-' }}, {{ $profil->kelurahan ?? '' }}, {{ $profil->kecamatan ?? '' }}, {{ $profil->kabupaten ?? '' }}, {{ $profil->provinsi ?? '' }}</span>
                        </div>
                        @if($profil && $profil->telepon)
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fa-solid fa-phone shrink-0" style="color:var(--color-primary)"></i>
                            <a href="tel:{{ $profil->telepon }}" class="transition-colors" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">{{ $profil->telepon }}</a>
                        </div>
                        @endif
                        @if($profil && $profil->email)
                        <div class="flex items-center gap-3 text-slate-600">
                            <i class="fa-solid fa-envelope shrink-0" style="color:var(--color-primary)"></i>
                            <a href="mailto:{{ $profil->email }}" class="transition-colors" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color=''">{{ $profil->email }}</a>
                        </div>
                        @endif
                        @if($profil && $profil->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->whatsapp) }}"
                           target="_blank"
                           class="flex items-center gap-3 text-white bg-green-600 hover:bg-green-700 rounded-xl p-3 mt-2 transition-colors">
                            <i class="fa-brands fa-whatsapp w-5 h-5 text-lg shrink-0"></i>
                            <span class="font-medium">Chat WhatsApp</span>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Identitas Sekolah --}}
                <div class="bg-white rounded-2xl p-6 border-2" style="border-color:var(--color-primary)">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-school shrink-0" style="color:var(--color-primary)"></i>
                        Identitas Sekolah
                    </h3>
                    <div class="space-y-2">
                        @php
                            $identitas = [
                                ['label' => 'Nama Sekolah',   'value' => $profil->nama_sekolah ?? '-'],
                                ['label' => 'NPSN',           'value' => $profil->npsn ?? '-'],
                                ['label' => 'NSS',            'value' => $profil->nss ?? '-'],
                                ['label' => 'Akreditasi',     'value' => $profil->akreditasi ?? '-'],
                                ['label' => 'Tahun Berdiri',  'value' => $profil->tahun_berdiri ?? '-'],
                                ['label' => 'Kode Pos',       'value' => $profil->kode_pos ?? '-'],
                                ['label' => 'Jumlah Siswa',   'value' => $profil->jumlah_siswa ? number_format($profil->jumlah_siswa) . ' Siswa' : '-'],
                                ['label' => 'Jumlah Guru',    'value' => $profil->jumlah_guru ? $profil->jumlah_guru . ' Guru' : '-'],
                            ];
                        @endphp
                        @foreach($identitas as $item)
                        <div class="flex items-start gap-2 text-sm text-gray-700">
                            <span class="shrink-0 w-5 h-5 text-white rounded-full text-xs flex items-center justify-center font-bold mt-0.5"
                                  style="background:var(--color-primary)">
                                {{ $loop->iteration }}
                            </span>
                            <span><span class="font-medium text-gray-900">{{ $item['label'] }}:</span> {{ $item['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ── KONTEN UTAMA ─────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Sejarah --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-book-open w-6 h-6 text-lg" style="color:var(--color-primary)"></i>
                        Sejarah Sekolah
                    </h2>
                    @if($profil && $profil->sejarah)
                        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed text-justify">
                            {!! nl2br(e($profil->sejarah)) !!}
                        </div>
                    @else
                        <p class="text-gray-400 text-sm italic">Informasi sejarah sekolah belum tersedia.</p>
                    @endif
                </div>

                {{-- Visi & Misi --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-slate-900 mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line w-6 h-6 text-lg" style="color:var(--color-primary)"></i>
                        Visi &amp; Misi
                    </h2>
                    <div class="space-y-4">

                        {{-- Visi --}}
                        <div class="relative rounded-2xl p-5 text-white overflow-hidden"
                             style="background:var(--color-primary)">
                            <div class="absolute inset-0"
                                 style="background-image:url('{{ asset('images/pattern.png') }}'); background-repeat:repeat; background-position:0 0; background-size:80px;"></div>
                            <div class="absolute inset-0 bg-black/40"></div>
                            <div class="relative flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-eye w-4 h-4 text-sm"></i>
                                </div>
                                <h3 class="font-bold text-white/90">Visi</h3>
                            </div>
                            <p class="relative text-white/90 leading-relaxed text-sm">
                                {{ $profil->visi ?? 'Belum diisi.' }}
                            </p>
                        </div>

                        {{-- Misi --}}
                        <div class="bg-white border-2 rounded-2xl p-5" style="border-color:var(--color-primary)">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0"
                                     style="background:var(--color-primary)">
                                    <i class="fa-solid fa-list-check text-white text-sm"></i>
                                </div>
                                <h3 class="font-bold" style="color:var(--color-primary)">Misi</h3>
                            </div>
                            @if($profil && $profil->misi)
                                @php $misiList = array_filter(explode("\n", $profil->misi)); @endphp
                                @if(count($misiList) > 1)
                                    <ol class="space-y-2">
                                        @foreach($misiList as $i => $item)
                                        <li class="flex items-start gap-2 text-sm text-gray-700">
                                            <span class="shrink-0 w-5 h-5 text-white rounded-full text-xs flex items-center justify-center font-bold mt-0.5"
                                                  style="background:var(--color-primary)">{{ $i + 1 }}</span>
                                            <span>{{ trim($item) }}</span>
                                        </li>
                                        @endforeach
                                    </ol>
                                @else
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $profil->misi }}</p>
                                @endif
                            @else
                                <p class="text-gray-400 text-sm italic">Belum diisi.</p>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Lokasi / Maps --}}
                @if($profil && $profil->maps_embed)
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot w-6 h-6 text-lg" style="color:var(--color-primary)"></i>
                        Lokasi Sekolah
                    </h2>
                    <div class="rounded-xl overflow-hidden border border-gray-200">
                        {!! $profil->maps_embed !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
