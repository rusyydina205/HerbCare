<nav x-data="{ open: false }" class="nav-glass border-b border-green-900/50 fixed top-0 left-0 right-0 z-50 h-20 shadow-xl">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">
            <!-- Left: Sidebar Toggle (patients) + Logo + Main Links -->
            <div class="flex items-center gap-3">

                {{-- Patient Sidebar Toggle Button --}}
                @if(\Illuminate\Support\Facades\Auth::guard('web')->check())
                <button onclick="togglePatientSidebar()"
                        id="patient-sidebar-toggle"
                        aria-expanded="false"
                        class="p-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-all flex items-center justify-center shrink-0 border border-white/10 hover:border-white/30"
                        title="Toggle Sidebar">
                    <svg id="sidebar-icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                @endif

                <a href="{{ Auth::guard('practitioner')->check() ? route('practitioner.dashboard') : route('dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="HerbCare Logo" class="w-11 h-11 rounded-full border-2 border-green-400/50 object-cover shadow-lg group-hover:scale-105 transition-transform" style="aspect-ratio:1/1;">
                    <span class="text-xl font-serif font-bold text-white tracking-wide group-hover:text-white transition-colors hidden sm:block">
                        HerbCare
                    </span>
                </a>
            </div>

            <!-- Right: User Dropdown & Notifications -->
            <div class="hidden md:flex items-center gap-6 sm:ms-6">
                <!-- Navigation Links -->
                <div class="flex items-center gap-6">
                    <a href="{{ url('/') }}" class="text-green-100 hover:text-white font-bold text-sm tracking-wide transition-colors {{ request()->is('/') ? 'border-b-2 border-green-400 text-white' : '' }}">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ Auth::user()->isPractitioner() ? route('practitioner.dashboard') : route('dashboard') }}" class="text-green-100 hover:text-white font-bold text-sm tracking-wide transition-colors {{ request()->routeIs('dashboard') || request()->routeIs('practitioner.dashboard') ? 'border-b-2 border-green-400 text-white' : '' }}">
                        {{ Auth::user()->isPractitioner() ? __('Management') : __('Recommendation') }}
                    </a>
                    <a href="{{ route('contact') }}" class="text-white hover:text-white font-bold text-sm tracking-wide transition-colors {{ request()->routeIs('contact') ? 'border-b-2 border-green-400 text-white' : '' }}">
                        {{ __('Contact Us') }}
                    </a>
                </div>

                @if(auth()->guard('web')->check())
                    @php
                        $unreadReplies = \App\Models\Message::where('patientId', auth()->user()->patientId)
                            ->where('is_read', false)
                            ->whereNotNull('reply')
                            ->count();
                    @endphp
                    <a href="{{ route('patient.messages') }}" class="relative group p-2.5 bg-green-900/40 rounded-xl border border-green-800 hover:bg-green-900/60 transition-all shadow-sm" title="Messages & Replies">
                        <svg class="w-6 h-6 text-green-100 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadReplies > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-amber-400 text-[#0f2818] text-[10px] font-black flex items-center justify-center rounded-full border-2 border-[#0f2818] animate-bounce">
                                {{ $unreadReplies }}
                            </span>
                        @endif
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-green-800 text-sm leading-4 font-bold rounded-xl text-white bg-green-900/40 hover:bg-green-900/60 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex items-center gap-2">
                                @php
                                    $user = auth()->user();
                                    $avatar = $user->profile_photo 
                                        ? asset('profile_photos/' . $user->profile_photo) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=ffffff&background=064e3b';
                                @endphp
                                <img src="{{ $avatar }}" 
                                     class="w-8 h-8 rounded-full border border-green-700 object-cover" alt="{{ $user->name }}">
                                <span>{{ $user->name }}</span>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-green-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(Auth::user()->isPractitioner())
                            <x-dropdown-link :href="route('practitioner.dashboard')">
                                {{ __('Practitioner Dashboard') }}
                            </x-dropdown-link>
                        @endif
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-green-100 hover:text-white hover:bg-green-800 focus:outline-none focus:bg-green-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="hidden md:hidden nav-glass border-b border-green-900/50 shadow-inner">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')" class="text-white hover:bg-green-800 transition-colors">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-green-800 transition-colors">
                {{ __('Recommendation') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')" class="text-white hover:bg-green-800 transition-colors">
                {{ __('Contact Us') }}
            </x-responsive-nav-link>
            @if(auth()->guard('web')->check())
                <x-responsive-nav-link :href="route('patient.messages')" :active="request()->routeIs('patient.messages')" class="text-white hover:bg-green-800 transition-colors">
                    <div class="flex items-center justify-between">
                        <span>{{ __('Messages & Replies') }}</span>
                        @if($unreadReplies > 0)
                            <span class="px-2 py-0.5 bg-amber-400 text-[#0f2818] text-[10px] font-black rounded-full shadow-sm">{{ $unreadReplies }}</span>
                        @endif
                    </div>
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-green-900/50">
            <div class="px-4 flex items-center gap-3">
                @php
                    $user = auth()->user();
                    $avatar = $user->profile_photo 
                        ? asset('profile_photos/' . $user->profile_photo) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=ffffff&background=064e3b';
                @endphp
                <img src="{{ $avatar }}" class="w-10 h-10 rounded-full border border-green-700 object-cover" alt="{{ $user->name }}">
                <div>
                    <div class="font-bold text-base text-white">{{ $user->name }}</div>
                    <div class="font-medium text-xs text-green-200/60">{{ $user->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::user()->isPractitioner())
                    <x-responsive-nav-link :href="route('practitioner.dashboard')" class="text-white hover:bg-green-800">
                        {{ __('Practitioner Dashboard') }}
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-green-800">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-white hover:bg-green-800">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
