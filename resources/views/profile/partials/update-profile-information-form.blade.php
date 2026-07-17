<section>
    <!-- Hidden file input for profile photo upload -->
    <input type="file" name="profile_photo" id="profile_photo_input" form="profile_update_form" class="hidden" onchange="document.getElementById('profile_update_form').submit()" />

    <form method="post" action="{{ route('profile.update') }}" id="profile_update_form" class="mt-2 space-y-8 text-black" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="space-y-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="text-xs font-bold text-black uppercase tracking-widest mb-2 px-1" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-2xl border-gray-200 bg-[#e6f3e8] py-3.5 shadow-sm font-medium cursor-not-allowed text-gray-500 px-4" :value="old('name', $user->name)" readonly />
                <p class="text-[10px] text-gray-400 mt-1.5 px-1 font-medium">Contact support to update your name.</p>
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold text-black uppercase tracking-widest mb-2 px-1" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-2xl border-gray-200 bg-[#e6f3e8] py-3.5 focus:border-[#064e3b] focus:ring-[#064e3b] shadow-sm font-medium px-4" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone" :value="__('Phone Number')" class="text-xs font-bold text-black uppercase tracking-widest mb-2 px-1" />
                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full rounded-2xl border-gray-200 bg-[#e6f3e8] py-3.5 focus:border-[#064e3b] focus:ring-[#064e3b] shadow-sm font-medium px-4" :value="old('phone', $user->phone)" required pattern="[0-9]+" title="Only digits are allowed" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

        </div>

        <div class="pt-6">
            <button type="submit" class="w-full bg-[#0f2818] hover:bg-[#08321f] py-4 rounded-[1rem] text-white text-xs font-extrabold uppercase tracking-widest shadow-xl flex items-center justify-center gap-3 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ __('Update Profile') }}
            </button>
        </div>
    </form>
</section>
