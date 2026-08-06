@extends('layouts.public')
@section('title', 'Berita & Kegiatan - SMA Negeri 1 Marangkayu')

@section('content')
<section class="py-14">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- DAFTAR BERITA --}}
            <div class="lg:col-span-2">
                <h2 class="section-title mb-8">Berita &amp; Kegiatan</h2>
                <div class="grid sm:grid-cols-2 gap-6">
                    @forelse($berita as $b)
                    <article class="card-hover flex flex-col group">
                        <div class="overflow-hidden h-44">
                            <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/600x350/1a3d6e/fff?text=Berita' }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 alt="{{ $b->judul }}">
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <span class="badge badge-primary mb-2 self-start">{{ ucfirst($b->tipe) }}</span>
                            <h3 class="font-semibold text-gray-800 text-sm mb-2 flex-1 group-hover:text-blue-800 transition-colors">
                                <a href="{{ route('berita.show', $b->slug) }}">{{ Str::limit($b->judul, 70) }}</a>
                            </h3>
                            <p class="text-gray-500 text-xs mb-3">{{ Str::limit(strip_tags($b->konten), 90) }}</p>
                            <div class="text-xs text-gray-400 flex items-center gap-1 mt-auto">
                                <i class="fa-regular fa-calendar"></i>
                                {{ optional($b->tanggal_publish)->translatedFormat('d M Y') ?? $b->created_at->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="col-span-2 text-center text-gray-400 py-16">Belum ada berita.</div>
                    @endforelse
                </div>
                <div class="mt-8">{{ $berita->links() }}</div>
            </div>

            {{-- SIDEBAR --}}
            <aside class="space-y-6">
                <div class="rounded-xl overflow-hidden shadow-sm border border-slate-100">
                    <div class="px-4 py-3 text-sm font-bold text-white" style="background-color: var(--color-primary)">Kategori</div>
                    <ul class="divide-y divide-slate-100">
                        @foreach($kategori as $k)
                        <li>
                            <a href="{{ route('berita.kategori', $k->slug) }}"
                               class="flex justify-between items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-800 transition-colors">
                                {{ $k->nama }}
                                <span class="text-xs font-semibold text-white px-2 py-0.5 rounded-full" style="background-color: var(--color-primary)">{{ $k->berita_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-xl overflow-hidden shadow-sm border border-slate-100">
                    <div class="px-4 py-3 text-sm font-bold text-white" style="background-color: var(--color-primary)">Berita Terkini</div>
                    <ul class="divide-y divide-slate-100">
                        @foreach($terkini as $t)
                        <li>
                            <a href="{{ route('berita.show', $t->slug) }}" class="flex gap-3 px-4 py-3 hover:bg-blue-50 transition-colors group">
                                <img src="{{ $t->thumbnail ? Storage::url($t->thumbnail) : 'https://placehold.co/60x50/1a3d6e/fff?text=B' }}"
                                     class="w-14 h-12 rounded-lg object-cover flex-shrink-0" alt="">
                                <div>
                                    <p class="text-xs font-medium text-gray-800 group-hover:text-blue-800 leading-snug">{{ Str::limit($t->judul, 55) }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ optional($t->tanggal_publish)->translatedFormat('d M Y') }}</p>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
