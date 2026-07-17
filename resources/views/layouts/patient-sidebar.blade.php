@php
    $currentRoute = request()->route()?->getName() ?? '';
    $patient = auth()->user();

    $unreadCount = 0;
    if ($patient instanceof \App\Models\Patient) {
        $unreadCount = \App\Models\Message::where('patientId', $patient->patientId)
            ->where('is_read', false)
            ->whereNotNull('reply')
            ->count();
    }

    $navItems = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'href'  => route('dashboard'),
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
        ],

        [
            'label' => 'Herb Library',
            'route' => 'herb.library',
            'href'  => route('herb.library'),
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
        ],
        [
            'label' => 'History',
            'route' => 'patient.history',
            'href'  => route('patient.history'),
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
        [
            'label' => 'Wellness Tips',
            'route' => 'patient.wellness',
            'href'  => route('patient.wellness'),
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
        ],
        [
            'label' => 'Contact Us',
            'route' => 'contact',
            'href'  => route('contact'),
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
        ],
        [
            'label' => 'Consultation',
            'route' => 'patient.messages',
            'href'  => route('patient.messages'),
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>',
            'badge' => $unreadCount,
        ],
    ];

    $tips = [
        'Drink warm water with lemon first thing in the morning to kickstart your digestion and hydrate your body.',
        'Add a pinch of turmeric to your meals — it has powerful anti-inflammatory and antioxidant properties.',
        'Practice 5 minutes of deep breathing exercises to reduce stress and improve mental clarity.',
        'Ginger tea before bed can ease digestion and calm the mind for better sleep quality.',
        'Take a 15-minute walk outdoors daily — sunlight boosts Vitamin D and elevates your mood naturally.',
        'Chamomile tea in the evening helps reduce anxiety and promotes deeper, more restorative sleep.',
        'Eat a handful of mixed nuts daily for healthy fats, protein, and essential minerals like magnesium.',
        'Apply peppermint oil to your temples to naturally relieve headaches and improve focus.',
        'Reduce screen time 1 hour before bed to improve melatonin production and sleep onset.',
        'Include garlic in your cooking regularly — it supports immune function and cardiovascular health.',
        'Try a warm Epsom salt bath once a week to relax muscles and replenish magnesium levels.',
        'Practice gratitude journaling before bed — write down 3 things you are grateful for each day.',
    ];
    $tipIndex = count($tips) > 0 ? date('z') % count($tips) : 0;
    $dailyTip = $tips[$tipIndex];
@endphp

<div class="flex flex-col h-full" style="background:#0f2818;">

    {{-- ── Nav Items ── --}}
    <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
        @foreach($navItems as $item)
        @php
            $isActive = $item['route'] && request()->routeIs($item['route']);
        @endphp
        <a href="{{ $item['href'] }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-150 group relative"
           style="{{ $isActive ? 'background: rgba(74,222,128,0.22);' : '' }}"
           onmouseover="if(!this.dataset.active) this.style.background='rgba(74,222,128,0.15)'"
           onmouseout="if(!this.dataset.active) this.style.background=''"
           {{ $isActive ? 'data-active=true' : '' }}>

            {{-- Active left bar --}}
            @if($isActive)
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 rounded-r-full" style="background:#4ade80;"></span>
            @endif

            {{-- Icon --}}
            <svg class="w-[19px] h-[19px] shrink-0"
                 style="color: {{ $isActive ? '#4ade80' : 'rgba(255,255,255,0.75)' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                {!! $item['icon'] !!}
            </svg>

            {{-- Label --}}
            <span class="text-[13.5px] font-semibold leading-none"
                  style="color: {{ $isActive ? '#ffffff' : 'rgba(255,255,255,0.85)' }}">
                {{ $item['label'] }}
            </span>

            {{-- Unread badge --}}
            @if(!empty($item['badge']) && $item['badge'] > 0)
                <span class="ml-auto shrink-0 min-w-[18px] h-[18px] px-1 bg-amber-400 text-[#0f2818] text-[10px] font-black flex items-center justify-center rounded-full">
                    {{ $item['badge'] }}
                </span>
            @endif
        </a>
        @endforeach
    </nav>

    {{-- ── Daily Wellness Tip Card ── --}}
    <div class="mx-3 mb-4 rounded-2xl p-4 relative overflow-hidden" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
        {{-- Decorative leaf --}}
        <svg class="absolute bottom-0 right-1 w-16 h-16 opacity-10" viewBox="0 0 80 80" fill="currentColor" style="color:white;">
            <path d="M70 5 C70 5 20 10 10 60 C30 40 55 35 70 5Z"/>
            <path d="M10 60 C10 60 25 45 40 42" stroke="white" stroke-width="2" fill="none"/>
        </svg>

        <div class="flex items-center gap-2 mb-2">
            {{-- Leaf icon --}}
            <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0" style="background:rgba(255,255,255,0.15)">
                <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3s4 0 8 4c4 4 4 9 4 9s-4 0-8-4S5 3 5 3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 21c0 0 2-6 8-10"/>
                </svg>
            </div>
            <span class="text-[12px] font-bold text-white">Daily Wellness Tip</span>
        </div>
        <p class="text-[11.5px] text-white/70 leading-relaxed pr-8">{{ $dailyTip }}</p>
    </div>

    {{-- ── Bottom: Profile & Logout ── --}}
    <div class="px-3 pb-4 pt-2 space-y-0.5" style="border-top: 1px solid rgba(255,255,255,0.1);">
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-150 group"
           onmouseover="this.style.background='rgba(74,222,128,0.15)'"
           onmouseout="this.style.background=''">
            <svg class="w-[19px] h-[19px] shrink-0 text-white/80 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-[13.5px] font-semibold text-white/90 group-hover:text-white">Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-150 group"
                    onmouseover="this.style.background='rgba(239,68,68,0.18)'"
                    onmouseout="this.style.background=''">
                <svg class="w-[19px] h-[19px] shrink-0 text-white/80 group-hover:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="text-[13.5px] font-semibold text-white/90 group-hover:text-red-300">Log Out</span>
            </button>
        </form>
    </div>
</div>
