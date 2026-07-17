<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ $backRoute ?? route('dashboard') }}" class="p-3 bg-white border border-gray-100 rounded-2xl text-gray-400 hover:text-[#064e3b] shadow-sm transition-all hover:shadow-md active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-serif font-bold text-2xl text-[#064e3b] leading-tight">
                {{ __('My Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fafdf7] min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-[-10px]"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-[-10px]"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm flex items-center gap-3 mb-6"
                >
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-green-800 font-medium text-sm">Profile updated successfully!</p>
                    <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-[#08321f] to-[#0f2818] text-white p-6 flex items-center gap-4">
                    <div class="relative flex-shrink-0">
                        @if($user->profile_photo)
                            <img src="{{ asset('profile_photos/' . $user->profile_photo) }}" alt="Avatar" class="w-16 h-16 rounded-xl border-2 border-white shadow-md object-cover">
                        @else
                            <div class="w-16 h-16 bg-[#e6f3e8] rounded-xl flex items-center justify-center text-[#064e3b] font-bold text-lg border-2 border-white shadow-sm">
                                {{ strtoupper(substr($user->name ?? 'P', 0, 2)) }}
                            </div>
                        @endif
                        <label for="profile_photo_input" class="absolute -bottom-1 -right-1 bg-[#064e3b] text-white rounded-full p-1 border border-white hover:scale-110 transition-transform cursor-pointer shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </label>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-green-200 uppercase tracking-widest font-bold">Account</p>
                        <h3 class="text-xl font-serif font-bold truncate">{{ $user->name }}</h3>
                        <p class="text-xs text-green-300 truncate">{{ $user->email }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-block bg-green-100 text-green-800 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider">Active</span>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 bg-gray-50/50">
                    <div class="grid grid-cols-3 text-center">
                        <button type="button" data-target="profile-info" class="tab-btn py-4 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 border-r border-gray-200 transition-all">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"></path></svg>
                            Profile Info
                        </button>
                        <button type="button" data-target="security" class="tab-btn py-4 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 border-r border-gray-200 transition-all">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3V6a3 3 0 00-6 0v2c0 1.657 1.343 3 3 3z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11v6a2 2 0 002 2h10a2 2 0 002-2v-6"></path></svg>
                            Security
                        </button>
                        <button type="button" data-target="delete" class="tab-btn py-4 text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 transition-all">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"></path></svg>
                            Delete Acc
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="p-8">
                    <!-- Profile Info Tab -->
                    <div id="profile-info">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 bg-[#e6f3e8] rounded-full flex items-center justify-center text-[#064e3b]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-serif font-bold text-[#0f2818]">Profile Information</h4>
                            </div>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Security Tab -->
                    <div id="security" class="hidden">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 bg-[#e6f3e8] rounded-full flex items-center justify-center text-[#064e3b]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-serif font-bold text-[#0f2818]">Update Password</h4>
                            </div>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Delete Account Tab -->
                    <div id="delete" class="hidden">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <!-- Privacy Banner -->
            <div class="mt-6 bg-[#0b2114] border border-[#1a3024] p-5 rounded-2xl flex items-center gap-3 text-[#f0fdf4]">
                <svg class="w-5 h-5 text-[#10b981] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <p class="text-xs font-semibold text-gray-300">Your privacy and security are our top priority.</p>
            </div>
        </div>
    </div>

    <script>
        (function() {
            function activate(target) {
                // Update tab buttons
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    if (btn.dataset.target === target) {
                        btn.classList.remove('text-gray-400', 'bg-gray-50/50', 'border-b', 'border-gray-200');
                        if (target === 'delete') {
                            btn.classList.add('text-red-600', 'bg-white', 'border-2', 'border-red-600', 'z-10');
                        } else {
                            btn.classList.add('text-[#0f2818]', 'bg-white', 'border-2', 'border-[#0f2818]', 'z-10');
                        }
                    } else {
                        btn.classList.remove('text-[#0f2818]', 'text-red-600', 'bg-white', 'border-2', 'border-[#0f2818]', 'border-red-600', 'z-10');
                        btn.classList.add('text-gray-400', 'bg-gray-50/50', 'border-b', 'border-gray-200');
                    }
                });

                // Update tab content
                ['profile-info', 'security', 'delete'].forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    if (id === target) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                });
            }

            // Add click listeners
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    activate(this.dataset.target);
                    const panel = document.getElementById(this.dataset.target);
                    if (panel) {
                        const input = panel.querySelector('input, textarea, button, select');
                        if (input) input.focus({ preventScroll: true });
                    }
                });
            });

            // Initialize
            activate('profile-info');
        })();
    </script>
</x-app-layout>
