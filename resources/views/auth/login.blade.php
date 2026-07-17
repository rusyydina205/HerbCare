<x-guest-layout>
    <x-slot name="panelLabel">
        {{ request('role') === 'practitioner' ? 'PRACTITIONER PORTAL' : 'PATIENT PORTAL' }}
    </x-slot>

    <div class="mb-8">
        <h2 class="font-serif text-2xl font-bold text-gray-900">Welcome back</h2>
        <p class="text-gray-500 text-sm mt-1">Sign in to your HerbCare account</p>
    </div>

    <!-- Role Selection Tabs -->
    <div class="flex p-1 bg-gray-100 rounded-xl mb-8">
        <a href="{{ route('login', ['role' => 'patient']) }}" 
           class="flex-1 py-2 text-center text-sm font-medium rounded-lg transition-all {{ request('role', 'patient') !== 'practitioner' ? 'bg-white text-green-800 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Patient
        </a>
        <a href="{{ route('login', ['role' => 'practitioner']) }}" 
           class="flex-1 py-2 text-center text-sm font-medium rounded-lg transition-all {{ request('role') === 'practitioner' ? 'bg-white text-green-800 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Practitioner
        </a>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Hidden Role -->
        <input type="hidden" name="role" value="{{ old('role', request('role', 'patient')) }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
            <x-text-input id="email" class="block mt-1.5 w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@herbcare.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-gray-600 uppercase tracking-wider" />
            <x-text-input id="password" class="block mt-1.5 w-full rounded-xl border-gray-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#166534] shadow-sm focus:ring-[#166534]" name="remember">
                <span class="ms-2 text-sm text-gray-500">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-[#166534] hover:text-[#14532d] font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 rounded-xl text-sm">
                {{ __('Sign In as ' . (request('role') === 'practitioner' ? 'Practitioner' : 'Patient')) }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-gray-500 text-sm">
                Don't have an account?
                <a href="{{ route('register', ['role' => request('role', 'patient')]) }}" class="text-[#166534] hover:text-[#14532d] font-semibold">Create Account</a>
            </p>
        </div>
    </form>

    <x-slot name="roleSwitch">
        @if(request('role') === 'practitioner')
            <p class="text-gray-400 text-sm">
                Not a TCM professional? <a href="{{ route('login', ['role' => 'patient']) }}" class="text-[#166534] hover:text-[#14532d] font-semibold">Sign in as Patient</a>
            </p>
        @else
            <p class="text-gray-400 text-sm">
                Are you a TCM professional? <a href="{{ route('login', ['role' => 'practitioner']) }}" class="text-[#166534] hover:text-[#14532d] font-semibold">Sign in as Practitioner</a>
            </p>
        @endif
    </x-slot>
</x-guest-layout>
