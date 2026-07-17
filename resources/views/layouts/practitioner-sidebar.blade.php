<div class="h-full flex flex-col bg-[#0f2818]">
    <!-- Practitioner Header/Logo -->
    <div class="p-8 border-b border-white/10">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-white/10 rounded-2xl flex items-center justify-center border border-white/20 shadow-sm">
                <svg class="w-6 h-6 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.054.585l-1.835 1.835a1 1 0 01-1.414-1.414l1.835-1.835a4 4 0 012.108-1.17l2.387-.477a4 4 0 002.574-.344l.318-.158a4 4 0 012.574-.344l2.387.477a4 4 0 012.108 1.17l1.835 1.835a1 1 0 01-1.414 1.414l-1.835-1.835z"></path></svg>
            </div>
            <div>
                <h1 class="text-xl font-serif font-bold text-white tracking-tight">HerbCare</h1>
                <p class="text-[10px] text-green-200/60 uppercase font-extrabold tracking-widest leading-none mt-1">Practitioner Suite</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 p-6 space-y-2 overflow-y-auto">
        <div class="px-5 mb-4">
            <p class="text-[10px] font-extrabold text-green-200/40 uppercase tracking-[0.2em]">Management</p>
        </div>
        
        <x-practitioner-nav-link :href="route('practitioner.dashboard')" :active="request()->routeIs('practitioner.dashboard') || request()->routeIs('practitioner.herbs.*')" icon="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
            Manage Herbs
        </x-practitioner-nav-link>

        <x-practitioner-nav-link :href="route('practitioner.symptoms.index')" :active="request()->routeIs('practitioner.symptoms.*')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
            Manage Symptoms
        </x-practitioner-nav-link>

        <x-practitioner-nav-link :href="route('practitioner.messages.index')" :active="request()->routeIs('practitioner.messages.*')" icon="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
            Patient Messages
            @php $pendingCount = \App\Models\Message::where('status', 'pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="ml-auto bg-white/20 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow-sm">{{ $pendingCount }}</span>
            @endif
        </x-practitioner-nav-link>

        <x-practitioner-nav-link :href="route('practitioner.analytics')" :active="request()->routeIs('practitioner.analytics')" icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            Analytics Dashboard
        </x-practitioner-nav-link>

        <div class="pt-8 px-5">
            <p class="text-[10px] font-extrabold text-green-200/40 uppercase tracking-[0.2em] mb-4">Account</p>
            
            {{-- Practitioner Profile Link --}}
            <a href="{{ route('practitioner.profile') }}" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-green-200/60 hover:text-white hover:bg-white/10 transition-all font-bold text-sm group mb-2 {{ request()->routeIs('practitioner.profile') ? 'bg-white/10 text-white' : '' }}">
                @php
                    $user = auth()->user();
                    $avatar = $user->profile_photo 
                        ? asset('profile_photos/' . $user->profile_photo) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=064e3b&background=e0efdb';
                @endphp
                <div class="relative shrink-0">
                    <img src="{{ $avatar }}" class="w-8 h-8 rounded-xl object-cover border border-white/10 shadow-sm" alt="Avatar">
                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-400 border-2 border-[#0f2818] rounded-full shadow-sm"></div>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate leading-tight text-white">{{ $user->name }}</p>
                    <p class="text-[9px] opacity-40 uppercase tracking-widest font-black">Profile Settings</p>
                </div>
                <svg class="w-4 h-4 opacity-0 group-hover:opacity-40 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-5 py-4 rounded-2xl text-green-200/60 hover:text-white hover:bg-white/10 transition-all font-bold text-sm group text-left">
                    <svg class="w-5 h-5 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>
</div>
