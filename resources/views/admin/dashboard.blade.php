@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php $cards = [
        ['label' => 'Berita',         'value' => $stats['berita'],     'icon' => 'fa-newspaper',       'color' => 'bg-blue-50',   'icon_color' => 'text-blue-600'],
        ['label' => 'Galeri',         'value' => $stats['galeri'],     'icon' => 'fa-image',           'color' => 'bg-purple-50', 'icon_color' => 'text-purple-600'],
        ['label' => 'Guru',           'value' => $stats['guru'],       'icon' => 'fa-chalkboard-user', 'color' => 'bg-amber-50',  'icon_color' => 'text-amber-600'],
        ['label' => 'Pesan Baru',     'value' => $stats['pesan_baru'], 'icon' => 'fa-envelope',        'color' => 'bg-red-50',    'icon_color' => 'text-red-600'],
    ]; @endphp
    @foreach($cards as $c)
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 {{ $c['color'] }}">
            <i class="fa-solid {{ $c['icon'] }} text-lg {{ $c['icon_color'] }}"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $c['value'] }}</p>
            <p class="text-xs text-gray-500">{{ $c['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- BERITA TERBARU --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-gray-800 text-sm">Berita Terbaru</h2>
            <a href="{{ route('admin.berita.index') }}"
               class="text-xs font-medium hover:underline"
               style="color: var(--color-primary)">Lihat Semua</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($berita_terbaru as $b)
            <div class="flex items-center gap-4 px-5 py-3">
                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100">
                    <img src="{{ $b->thumbnail ? Storage::url($b->thumbnail) : 'https://placehold.co/40x40/1a3d6e/fff?text=B' }}"
                         class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.berita.edit', $b) }}"
                       class="text-sm font-medium text-gray-800 hover:text-blue-800 truncate block">
                        {{ Str::limit($b->judul, 50) }}
                    </a>
                    <p class="text-xs text-gray-400">{{ $b->created_at->format('d M Y') }}</p>
                </div>
                @if($b->status === 'published')
                <span class="badge badge-green flex-shrink-0">Published</span>
                @else
                <span class="badge badge-gray flex-shrink-0">Draft</span>
                @endif
            </div>
            @empty
            <p class="px-5 py-8 text-sm text-center text-gray-400">Belum ada berita.</p>
            @endforelse
        </div>
    </div>

    {{-- PESAN MASUK --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-gray-800 text-sm">Pesan Masuk</h2>
            <a href="{{ route('admin.pesan.index') }}"
               class="text-xs font-medium hover:underline"
               style="color: var(--color-primary)">Lihat Semua</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($pesan_terbaru as $p)
            <a href="{{ route('admin.pesan.show', $p) }}"
               class="block px-5 py-3 hover:bg-slate-50 transition-colors {{ !$p->is_read ? 'bg-blue-50/50' : '' }}">
                <div class="flex items-center justify-between mb-0.5">
                    <span class="text-sm font-medium text-gray-800">{{ $p->nama }}</span>
                    <span class="text-xs text-gray-400">{{ $p->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-xs text-gray-500 truncate">{{ $p->subjek }}</p>
                @if(!$p->is_read)
                <span class="inline-block mt-1 badge bg-red-100 text-red-600">Baru</span>
                @endif
            </a>
            @empty
            <p class="px-5 py-8 text-sm text-center text-gray-400">Tidak ada pesan.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- QUICK ACCESS --}}
<div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
    @php $quick = [
        ['label'=>'Tambah Berita',  'icon'=>'fa-plus', 'route'=>route('admin.berita.create'),   'color'=>'var(--color-primary)'],
        ['label'=>'Upload Galeri',  'icon'=>'fa-upload','route'=>route('admin.galeri.create'),  'color'=>'#7c3aed'],
        ['label'=>'Tambah Guru',    'icon'=>'fa-user-plus','route'=>route('admin.guru-staf.create'),'color'=>'#d97706'],
        ['label'=>'Atur Slider',    'icon'=>'fa-sliders','route'=>route('admin.slider.index'),  'color'=>'#059669'],
    ]; @endphp
    @foreach($quick as $q)
    <a href="{{ $q['route'] }}"
       class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 flex items-center gap-3 hover:shadow-md transition-shadow group">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center text-white text-sm flex-shrink-0 transition-transform group-hover:scale-110"
             style="background-color: {{ $q['color'] }}">
            <i class="fa-solid {{ $q['icon'] }}"></i>
        </div>
        <span class="text-sm font-medium text-gray-700">{{ $q['label'] }}</span>
    </a>
    @endforeach
</div>

@endsection
