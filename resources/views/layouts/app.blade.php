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

            /* Navbar glass */
            .nav-glass {
                background: rgba(15, 40, 24, 0.92);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            /* Hero gradient */
            .hero-gradient {
                background: linear-gradient(135deg, #0f2818 0%, #1a4d2e 40%, #2d6a4f 70%, #d4edda 100%);
            }

            /* Push content below fixed navbar */
            .navbar-spacer {
                padding-top: 80px !important;
            }

            /* Patient sidebar */
            .patient-sidebar {
                width: 260px;
                min-width: 260px;
                transition: transform 0.3s ease-in-out;
            }
            .patient-sidebar.sidebar-hidden {
                transform: translateX(-100%);
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                top: 80px;
                background: rgba(0,0,0,0.5);
                z-index: 40;
            }
            .sidebar-overlay.active {
                display: block;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#fbfbfb]" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex flex-col">

            {{-- ── Navbar (shown for guests + patients) ── --}}
            @if(!\Illuminate\Support\Facades\Auth::guard('practitioner')->check())
                @include('layouts.navigation')
            @endif

            <div class="flex-1 flex min-h-0 relative">

                {{-- ══════════════════════════════════════
                     PRACTITIONER SIDEBAR
                ══════════════════════════════════════ --}}
                @if(\Illuminate\Support\Facades\Auth::guard('practitioner')->check())
                    <!-- Practitioner Mobile Overlay -->
                    <div x-show="sidebarOpen"
                         x-transition:enter="transition-opacity ease-linear duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity ease-linear duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click="sidebarOpen = false"
                         class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

                    <!-- Practitioner Sidebar -->
                    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                           class="fixed inset-y-0 left-0 w-80 bg-[#0f2818] z-50 transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 flex-shrink-0 shadow-[10px_0_30px_rgba(0,0,0,0.05)]">
                        @include('layouts.practitioner-sidebar')
                    </aside>

                    <div class="flex-1 flex flex-col bg-[#fafdf7] overflow-y-auto w-full">
                        <!-- Practitioner Mobile Header -->
                        <header class="lg:hidden bg-[#0f2818] px-6 py-4 flex items-center justify-between z-30 shadow-md">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-full border border-white/20">
                                <span class="text-white font-serif font-bold text-lg">HerbCare</span>
                            </div>
                            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl bg-white/10 text-white hover:bg-white/20 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                        </header>

                        @isset($header)
                            <header class="bg-[#0f2818] backdrop-blur-xl border-b border-white/10 sticky top-0 z-10 w-full shadow-lg">
                                <div class="max-w-7xl mx-auto px-6 lg:px-10 py-5 lg:py-8">
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset

                        <main class="flex-1 p-6 lg:p-10">
                            {{ $slot }}
                        </main>
                    </div>

                {{-- ══════════════════════════════════════
                     PATIENT SIDEBAR + CONTENT
                ══════════════════════════════════════ --}}
                @elseif(\Illuminate\Support\Facades\Auth::guard('web')->check())

                    {{-- Overlay --}}
                    <div id="patient-sidebar-overlay" class="sidebar-overlay" onclick="togglePatientSidebar()"></div>

                    {{-- Patient Sidebar --}}
                    <aside id="patient-sidebar"
                           class="patient-sidebar sidebar-hidden fixed z-50 shadow-2xl flex-shrink-0 overflow-y-auto"
                           style="top:80px; bottom:0; left:0; background:#0f2818;">
                        @include('layouts.patient-sidebar')
                    </aside>

                    {{-- Main Content area --}}
                    <div class="flex-1 flex flex-col w-full overflow-x-hidden navbar-spacer">
                        @isset($header)
                            <header class="{{ $attributes->get('headerClasses', 'bg-gray-100 border-b border-gray-200 shadow-sm') }} w-full">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset

                        <main class="flex-1">
                            {{ $slot }}
                        </main>
                    </div>

                    <script>
                        function togglePatientSidebar() {
                            const sidebar = document.getElementById('patient-sidebar');
                            const overlay = document.getElementById('patient-sidebar-overlay');
                            const btn     = document.getElementById('patient-sidebar-toggle');
                            if (!sidebar) return;
                            const isHidden = sidebar.classList.contains('sidebar-hidden');
                            sidebar.classList.toggle('sidebar-hidden', !isHidden);
                            overlay.classList.toggle('active', isHidden);
                            if (btn) {
                                btn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                            }
                        }
                        // Close sidebar when clicking a nav link inside it
                        document.addEventListener('DOMContentLoaded', function () {
                            const sidebar = document.getElementById('patient-sidebar');
                            if (sidebar) {
                                sidebar.querySelectorAll('a').forEach(function(link) {
                                    link.addEventListener('click', function() {
                                        const overlay = document.getElementById('patient-sidebar-overlay');
                                        sidebar.classList.add('sidebar-hidden');
                                        if (overlay) overlay.classList.remove('active');
                                    });
                                });
                            }
                        });
                    </script>

                {{-- ── Guest (no sidebar) ── --}}
                @else
                    <div class="flex-1 flex flex-col relative w-full navbar-spacer">
                        @isset($header)
                            <header class="bg-gray-100 backdrop-blur-xl border-b border-gray-200 shadow-sm sticky top-20 z-20 w-full">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset

                        <main class="flex-1">
                            {{ $slot }}
                        </main>
                    </div>
                @endif

            </div>
        </div>
    </body>
</html>
