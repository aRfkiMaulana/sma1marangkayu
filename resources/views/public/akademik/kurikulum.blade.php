@extends('layouts.public')
@section('title', 'Kurikulum - SMA Negeri 1 Marangkayu')

@section('content')
@include('public.akademik._subnav')

<section class="py-5 pb-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">

        {{-- Hero Banner --}}
        <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden mb-6">
            <div class="relative overflow-hidden px-6 py-8 md:px-10 md:py-14 text-white">
                <div class="absolute inset-0"
                     style="background-image:url('{{ asset('images/wheat.webp') }}'); background-repeat:repeat; background-position:0 0; background-size:200px;">
                </div>
                
                <div class="relative max-w-2xl">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 text-white mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg> Kurikulum Resmi
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-3">Kurikulum Merdeka</h1>
                    <p class="text-blue-100 text-sm md:text-base leading-relaxed">
                        SMA Negeri 1 Marangkayu menerapkan Kurikulum Merdeka sebagai pedoman penyelenggaraan
                        pembelajaran yang berpusat pada siswa, fleksibel, dan relevan dengan kebutuhan zaman.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- ── KONTEN UTAMA ────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Apa itu Kurikulum Merdeka --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-book-open w-6 h-6 text-lg" style="color:var(--color-primary)"></i>
                        Apa itu Kurikulum Merdeka?
                    </h2>
                    <div class="space-y-3 text-sm text-gray-600 leading-relaxed">
                        <p><strong class="text-gray-900">Kurikulum Merdeka</strong> adalah kurikulum dengan pembelajaran intrakurikuler yang beragam, di mana konten akan lebih optimal agar siswa memiliki cukup waktu untuk mendalami konsep dan menguatkan kompetensi.</p>
                        <p>Kurikulum ini memberikan keleluasaan bagi guru untuk memilih perangkat ajar yang sesuai dengan kebutuhan dan karakteristik peserta didik, serta memberikan ruang bagi satuan pendidikan untuk mengembangkan kurikulum operasional sesuai kondisi setempat.</p>
                        <p>Di SMAN 1 Marangkayu, Kurikulum Merdeka diterapkan secara penuh mulai tahun ajaran 2023/2024 dengan pendekatan pembelajaran berbasis proyek (<strong class="text-gray-900">Project-Based Learning</strong>) dan penguatan profil pelajar Pancasila.</p>
                    </div>
                </div>

                {{-- Tujuan Kurikulum --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-bullseye w-6 h-6 text-lg" style="color:var(--color-primary)"></i>
                        Tujuan Penerapan
                    </h2>
                    <div class="space-y-3">
                        @php
                            $tujuan = [
                                ['bg'=>'bg-blue-50','border'=>'border-blue-100','icon_color'=>'text-blue-600','icon'=>'fa-user-graduate','judul'=>'Pembelajaran Berpusat Siswa','desc'=>'Siswa menjadi subjek aktif dalam proses pembelajaran, bukan sekadar penerima informasi pasif dari guru.'],
                                ['bg'=>'bg-emerald-50','border'=>'border-emerald-100','icon_color'=>'text-emerald-600','icon'=>'fa-seedling','judul'=>'Penguatan Profil Pelajar Pancasila','desc'=>'Membentuk karakter siswa yang beriman, berkebinekaan global, bergotong royong, kreatif, bernalar kritis, dan mandiri.'],
                                ['bg'=>'bg-amber-50','border'=>'border-amber-100','icon_color'=>'text-amber-600','icon'=>'fa-diagram-project','judul'=>'Pembelajaran Berbasis Proyek','desc'=>'Siswa mengerjakan proyek nyata yang relevan dengan kehidupan sehari-hari untuk mengembangkan kompetensi lintas mata pelajaran.'],
                                ['bg'=>'bg-purple-50','border'=>'border-purple-100','icon_color'=>'text-purple-600','icon'=>'fa-sliders','judul'=>'Fleksibilitas Pembelajaran','desc'=>'Guru leluasa memilih metode, media, dan perangkat ajar terbaik sesuai kebutuhan dan karakteristik siswa di kelas.'],
                                ['bg'=>'bg-sky-50','border'=>'border-sky-100','icon_color'=>'text-sky-600','icon'=>'fa-chart-line','judul'=>'Pengembangan Kompetensi Holistik','desc'=>'Tidak hanya kognitif, namun juga afektif dan psikomotorik untuk menyiapkan lulusan yang siap menghadapi tantangan global.'],
                            ];
                        @endphp
                        @foreach($tujuan as $t)
                        <div class="flex items-start gap-4 p-4 rounded-xl border {{ $t['bg'] }} {{ $t['border'] }}">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 bg-white">
                                <i class="fa-solid {{ $t['icon'] }} {{ $t['icon_color'] }}"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $t['judul'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $t['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Struktur Kurikulum --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group w-6 h-6 text-lg" style="color:var(--color-primary)"></i>
                        Struktur Kurikulum
                    </h2>
                    <ul class="space-y-2.5">
                        @php
                            $struktur = [
                                'Mata pelajaran wajib meliputi: Pendidikan Agama, PPKn, Bahasa Indonesia, Matematika, Bahasa Inggris, PJOK, dan Seni Budaya',
                                'Mata pelajaran pilihan (fase F) sesuai minat dan bakat siswa: IPA, IPS, atau campuran lintas bidang',
                                'Projek Penguatan Profil Pelajar Pancasila (P5) sebanyak 20–30% dari total jam pelajaran',
                                'Pemilihan mata pelajaran pilihan dimulai di kelas XI berdasarkan minat, bakat, dan rencana studi lanjut',
                                'Tidak ada lagi penjurusan IPA/IPS di kelas X — semua siswa mengikuti kurikulum yang sama',
                                'Asesmen berbasis kompetensi: formatif, sumatif, dan projek nyata',
                                'Program remedial dan pengayaan terintegrasi dalam siklus pembelajaran',
                            ];
                        @endphp
                        @foreach($struktur as $item)
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5 text-white text-xs font-bold"
                                  style="background:var(--color-primary)">✓</span>
                            <span>{{ $item }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Profil Pelajar Pancasila --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2 ml-2">
                        6 Dimensi Profil Pelajar Pancasila
                    </h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @php
                            $dimensi = [
                                ['icon'=>'fa-mosque','label'=>'Beriman & Bertakwa','desc'=>'Berakhlak mulia kepada Tuhan, sesama manusia, dan alam semesta'],
                                ['icon'=>'fa-globe','label'=>'Berkebinekaan Global','desc'=>'Menghargai keragaman budaya, bangga sebagai bangsa Indonesia'],
                                ['icon'=>'fa-hands-holding','label'=>'Bergotong Royong','desc'=>'Berkolaborasi, peduli, dan berbagi dengan sesama'],
                                ['icon'=>'fa-lightbulb','label'=>'Mandiri','desc'=>'Bertanggung jawab atas proses dan hasil belajarnya sendiri'],
                                ['icon'=>'fa-brain','label'=>'Bernalar Kritis','desc'=>'Mengolah informasi secara objektif dan membuat keputusan tepat'],
                                ['icon'=>'fa-palette','label'=>'Kreatif','desc'=>'Menghasilkan karya orisinal yang bermakna dan berdampak'],
                            ];
                        @endphp
                        @foreach($dimensi as $d)
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-white"
                                 style="background:var(--color-primary)">
                                <i class="fa-solid {{ $d['icon'] }} text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $d['label'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $d['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ── SIDEBAR KANAN ────────────────────────────── --}}
            <div class="space-y-5 ">

                {{-- Fakta Kurikulum --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100"
                         style="background:linear-gradient(to right, color-mix(in srgb, var(--color-primary) 8%, white), white)">
                        <p class="text-xs font-bold uppercase tracking-wide" style="color:var(--color-primary)">Fakta Kurikulum</p>
                    </div>
                    <div class="divide-y divide-gray-50 text-sm">
                        @php
                            $fakta = [
                                ['label'=>'Kurikulum',      'value'=>'Kurikulum Merdeka'],
                                ['label'=>'Diterapkan sejak','value'=>'T.A. 2023/2024'],
                                ['label'=>'Fase',           'value'=>'Fase E (X) & F (XI–XII)'],
                                ['label'=>'Penjurusan',     'value'=>'Tidak ada di kelas X'],
                                ['label'=>'Program P5',     'value'=>'20–30% Jam Pelajaran'],
                                ['label'=>'Asesmen',        'value'=>'Berbasis Kompetensi'],
                            ];
                        @endphp
                        @foreach($fakta as $f)
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-gray-500">{{ $f['label'] }}</span>
                            <span class="font-semibold text-gray-900 text-right">{{ $f['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tahapan Implementasi --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-list-ol" style="color:var(--color-primary)"></i>
                        Tahapan Implementasi
                    </h3>
                    <ol class="space-y-3 relative before:absolute before:left-[15px] before:top-2 before:h-[calc(100%-16px)] before:w-px before:bg-gray-100">
                        @php
                            $tahapan = [
                                ['judul'=>'Sosialisasi & Pelatihan Guru','desc'=>'Seluruh guru mengikuti pelatihan Implementasi Kurikulum Merdeka (IKM) dari Kemendikbud.'],
                                ['judul'=>'Penyusunan Kurikulum Operasional','desc'=>'Sekolah menyusun KOSP (Kurikulum Operasional Satuan Pendidikan) sesuai kondisi lokal.'],
                                ['judul'=>'Implementasi Pembelajaran','desc'=>'Penerapan modul ajar, ATP, dan P5 di semua kelas secara bertahap.'],
                                ['judul'=>'Asesmen & Evaluasi','desc'=>'Penilaian berbasis kompetensi, laporan hasil belajar, dan evaluasi program P5.'],
                            ];
                        @endphp
                        @foreach($tahapan as $i => $t)
                        <li class="flex items-start gap-3 pl-1">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 text-white text-xs font-bold z-10"
                                  style="background:var(--color-primary)">{{ $i + 1 }}</span>
                            <div>
                                <p class="font-semibold text-gray-900 text-xs">{{ $t['judul'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $t['desc'] }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </div>

                {{-- Jelajahi Akademik --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Jelajahi Akademik</p>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @php
                            $links = [
                                ['route'=>'akademik.ekstrakurikuler','icon'=>'fa-star',         'label'=>'Ekstrakurikuler'],
                                ['route'=>'akademik.kalender',       'icon'=>'fa-calendar-days','label'=>'Kalender Akademik'],
                                ['route'=>'akademik.prestasi',       'icon'=>'fa-trophy',       'label'=>'Prestasi Sekolah'],
                            ];
                        @endphp
                        @foreach($links as $link)
                        <a href="{{ route($link['route']) }}"
                           class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                            <i class="fa-solid {{ $link['icon'] }} w-4 h-4 text-sm" style="color:var(--color-primary)"></i>
                            <span class="text-sm font-medium text-gray-700 flex-1">{{ $link['label'] }}</span>
                            <i class="fa-solid fa-chevron-right text-xs text-gray-400 group-hover:text-gray-600"></i>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
