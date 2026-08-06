{{-- Sub-navigasi Akademik --}}
<div class="sticky top-[81px] z-40 bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-4">
        <div class="flex items-center py-2.5 overflow-x-auto gap-1.5">

            @php
                $navItems = [
                    [
                        'route' => 'akademik.kurikulum',
                        'label' => 'Kurikulum',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                    ],
                    [
                        'route' => 'akademik.ekstrakurikuler',
                        'label' => 'Ekstrakurikuler',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    ],
                    [
                        'route' => 'akademik.kalender',
                        'label' => 'Kalender Akademik',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    ],
                    [
                        'route' => 'akademik.prestasi',
                        'label' => 'Prestasi',
                        'icon'  => '<i class="fa-solid fa-trophy"></i>',
                    ],
                ];
            @endphp

            @foreach($navItems as $item)
                @php $isActive = request()->routeIs($item['route'].'*'); @endphp
                <a href="{{ route($item['route']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all whitespace-nowrap"
                   style="{{ $isActive ? 'background:var(--color-primary);color:#fff' : 'color:#475569' }}"
                   @if(!$isActive) onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background=''" @endif>
                    @if(str_contains($item['icon'], '<path'))
                        <svg class="w-4 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                    @else
                        {!! $item['icon'] !!}
                    @endif
                    {{ $item['label'] }}
                </a>
            @endforeach

        </div>
    </div>
</div>
