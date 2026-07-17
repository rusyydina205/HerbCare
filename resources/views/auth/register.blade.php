<x-guest-layout>
    <x-slot name="panelLabel">
        {{ request('role') === 'practitioner' ? 'PRACTITIONER PORTAL' : 'PATIENT PORTAL' }}
    </x-slot>

    <div class="mb-8">
        <h2 class="font-serif text-2xl font-bold text-gray-900">
            {{ request('role') === 'practitioner' ? 'Create Practitioner Account' : 'Create Patient Account' }}
        </h2>
        <p class="text-gray-500 text-sm mt-1">Join our community of botanical seekers.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Hidden Role -->
        <input type="hidden" name="role" value="{{ request('role', 'patient') }}">

        <!-- Full Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
            <x-text-input id="name" class="block mt-1.5 w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Elias Thorne" 
                pattern="^[A-Za-z\s]+$"
                title="Only letters and spaces are allowed" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-5">
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
            <x-text-input id="email" class="block mt-1.5 w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@herbcare.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-5">
            <x-input-label for="phone" :value="__('Phone Number')" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
            <x-text-input id="phone" class="block mt-1.5 w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500" type="tel" name="phone" :value="old('phone')" required placeholder="1234567890" pattern="[0-9]+" title="Only digits are allowed" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
            <x-text-input id="password" class="block mt-1.5 w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-5">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 rounded-xl text-sm">
                {{ request('role') === 'practitioner' ? __('Create Practitioner Account') : __('Create Patient Account') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-gray-500 text-sm">
                Already registered?
                <a href="{{ route('login') }}" class="text-[#166534] hover:text-[#14532d] font-semibold">Sign In</a>
            </p>
        </div>
    </form>

    <x-slot name="roleSwitch">
        @if(request('role') === 'practitioner')
            <p class="text-gray-400 text-sm">
                Not a practitioner? <a href="{{ route('register') }}" class="text-[#166534] hover:text-[#14532d] font-semibold">Register as Patient</a>
            </p>
        @else
            <p class="text-gray-400 text-sm">
                Are you a TCM professional? <a href="{{ route('register', ['role' => 'practitioner']) }}" class="text-[#166534] hover:text-[#14532d] font-semibold">Join as a Practitioner</a>
            </p>
        @endif
    </x-slot>
</x-guest-layout>
