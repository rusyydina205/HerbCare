<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HerbCare') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700&family=inter:300,400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
            .font-serif { font-family: 'Playfair Display', serif; }

            .auth-bg {
                background: linear-gradient(135deg, #0f2818 0%, #1a4d2e 50%, #2d6a4f 100%);
            }

            .leaf-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5 C30 5 45 20 45 35 C45 50 30 55 30 55 C30 55 15 50 15 35 C15 20 30 5 30 5Z' fill='none' stroke='rgba(255,255,255,0.04)' stroke-width='1'/%3E%3C/svg%3E");
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }
            .float-animation { animation: float 6s ease-in-out infinite; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Panel: Inspirational Content -->
            <div class="hidden lg:flex lg:w-1/2 auth-bg relative flex-col justify-between p-12 overflow-hidden">
                <!-- Leaf pattern overlay -->
                <div class="absolute inset-0 leaf-pattern"></div>

                <!-- Decorative blobs -->
                <div class="absolute top-20 right-10 w-64 h-64 bg-green-400/10 rounded-full blur-3xl float-animation"></div>
                <div class="absolute bottom-32 left-10 w-80 h-80 bg-green-300/5 rounded-full blur-3xl float-animation" style="animation-delay: 3s;"></div>

                <!-- Top: Logo -->
                <div class="relative z-10">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="HerbCare" class="w-10 h-10 rounded-full border-2 border-green-400/50 object-cover" style="aspect-ratio:1/1;">
                        <span class="text-xl font-serif font-bold text-green-100 tracking-wide">HerbCare</span>
                    </a>
                </div>

                <!-- Middle: Inspirational text -->
                <div class="relative z-10 max-w-md">
                    <span class="inline-block px-3 py-1 bg-green-800/40 border border-green-500/30 rounded-full text-green-300 text-xs font-medium tracking-wider uppercase mb-6">
                        {{ $panelLabel ?? 'PATIENT PORTAL' }}
                    </span>
                    <h1 class="font-serif text-4xl xl:text-5xl font-bold text-white leading-tight mb-6">
                        Begin your<br>healing<br>journey.
                    </h1>
                    <p class="text-green-200/70 text-base leading-relaxed">
                        Cultivate a personalized path to wellness through ancient botanical wisdom and modern TCM insights.
                    </p>

                    <!-- Quote card -->
                    <div class="mt-10 bg-green-900/40 backdrop-blur-sm rounded-2xl p-6 border border-green-500/20">
                        <div class="flex items-start gap-3">
                            <div class="text-3xl">🌿</div>
                            <div>
                                <p class="text-green-200/80 text-sm italic leading-relaxed">
                                    "The patient's journey to the garden where health blooms."
                                </p>
                                <p class="text-green-400/50 text-xs mt-2">— Ancient Wisdom</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom: Nav links -->
                <div class="relative z-10 flex items-center gap-6 text-sm text-green-400/50">
                    <a href="/" class="hover:text-green-200 transition-colors">Home</a>
                    <span>·</span>
                    <a href="#" class="hover:text-green-200 transition-colors">Privacy</a>
                    <span>·</span>
                    <a href="#" class="hover:text-green-200 transition-colors">Support</a>
                </div>
            </div>

            <!-- Right Panel: Auth Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 bg-[#fafdf7] relative">
                <!-- Back Button (Floating) -->
                <div class="absolute top-4 left-8">
                    <a href="/" class="group flex items-center gap-3 text-gray-400 hover:text-green-800 transition-all">
                        <div class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center shadow-sm group-hover:shadow-md transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest hidden sm:inline-block">Back to home</span>
                    </a>
                </div>

                <!-- Mobile Logo (visible only on small screens) -->
                <div class="lg:hidden mb-8 text-center mt-12">
                    <a href="/" class="flex flex-col items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="HerbCare" class="w-16 h-16 rounded-full border-2 border-green-600/30 object-cover mb-3" style="aspect-ratio:1/1;">
                        <span class="text-2xl font-serif font-bold text-green-800 tracking-wide">HerbCare</span>
                        <p class="text-green-600/60 text-xs mt-1">Traditional Herbal Recommendations</p>
                    </a>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>

                <!-- Role switch link -->
                @isset($roleSwitch)
                    <div class="mt-6 text-center">
                        {{ $roleSwitch }}
                    </div>
                @endisset
            </div>
        </div>
    </body>
</html>
