<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="HerbCare - Traditional Chinese Medicine herbal recommendation system based on patient symptoms">

        <title>HerbCare - Traditional Herbal Recommendations</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700&family=inter:300,400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            body { font-family: 'Inter', sans-serif; }
            .font-serif { font-family: 'Playfair Display', serif; }

            /* Smooth scroll */
            html { scroll-behavior: smooth; }

            /* Hero gradient */
            .hero-gradient {
                background: linear-gradient(135deg, #0f2818 0%, #1a4d2e 40%, #2d6a4f 70%, #d4edda 100%);
            }

            /* Navbar glass */
            .nav-glass {
                background: rgba(15, 40, 24, 0.92);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            /* Floating animation */
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            .float-animation { animation: float 6s ease-in-out infinite; }

            /* Fade in */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
            .fade-in-up-delay { animation: fadeInUp 0.8s ease-out 0.2s forwards; opacity: 0; }
            .fade-in-up-delay-2 { animation: fadeInUp 0.8s ease-out 0.4s forwards; opacity: 0; }

            /* Leaf decoration */
            .leaf-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5 C30 5 45 20 45 35 C45 50 30 55 30 55 C30 55 15 50 15 35 C15 20 30 5 30 5Z' fill='none' stroke='rgba(255,255,255,0.04)' stroke-width='1'/%3E%3C/svg%3E");
            }

            /* Button hover glow */
            .btn-glow:hover {
                box-shadow: 0 0 25px rgba(22, 101, 52, 0.4);
            }
        </style>
    </head>
    <body class="bg-[#fafdf7] text-gray-800 antialiased">

        <!-- ===== NAVBAR ===== -->
        <nav class="nav-glass fixed top-0 left-0 right-0 z-50 border-b border-green-900/30">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="HerbCare Logo" class="w-12 h-12 rounded-full border-2 border-green-400/50 object-cover shadow-lg group-hover:scale-105 transition-transform" style="aspect-ratio:1/1;">
                        <span class="text-2xl font-serif font-bold text-green-100 tracking-wider group-hover:text-white transition-colors">HerbCare</span>
                    </a>

                    <!-- Nav Links -->
                    <div class="hidden md:flex items-center gap-10">
                        <a href="#home" class="text-green-100 hover:text-white text-[11px] font-black tracking-[0.2em] uppercase transition-all relative group">
                            Home
                            <span class="absolute bottom-[-6px] left-0 w-0 h-[2px] bg-green-400 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="#about" class="text-green-100/70 hover:text-white text-[11px] font-black tracking-[0.2em] uppercase transition-all relative group">
                            About
                            <span class="absolute bottom-[-6px] left-0 w-0 h-[2px] bg-green-400 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="#contact" class="text-green-100/70 hover:text-white text-[11px] font-black tracking-[0.2em] uppercase transition-all relative group">
                            Contact
                            <span class="absolute bottom-[-6px] left-0 w-0 h-[2px] bg-green-400 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-green-100 hover:text-white text-xs font-bold tracking-widest uppercase transition-colors">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-green-700 hover:bg-green-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-green-900/40 transition-all uppercase tracking-widest">Sign Up Now</a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- ===== HERO SECTION ===== -->
        <section id="home" class="hero-gradient relative min-h-screen flex items-center overflow-hidden pt-20">
            <!-- Leaf pattern overlay -->
            <div class="absolute inset-0 leaf-pattern opacity-40"></div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 w-full py-12">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Left: Text Content -->
                    <div class="text-center lg:text-left">
                        <div class="fade-in-up">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/5 border border-white/10 rounded-full text-green-300 text-[10px] font-bold tracking-[0.2em] uppercase mb-8 backdrop-blur-md">
                                🌿 Traditional Chinese Medicine
                            </span>
                        </div>

                        <h1 class="fade-in-up-delay font-serif text-5xl sm:text-6xl lg:text-7xl font-bold leading-[0.95] mb-10 tracking-tight">
                            <span class="text-white">Discover the Wisdom</span> <br>
                            <span class="text-green-400">of Traditional</span> <br>
                            <span class="text-green-400">Chinese Medicine</span>
                        </h1>

                        <p class="fade-in-up-delay-2 text-green-100/80 text-lg max-w-xl mx-auto lg:mx-0 mb-8 leading-relaxed font-sans">
                            Explore our curated collection of healing herbs, learn preparation methods, and find natural remedies for your wellness journey.
                        </p>

                        <!-- CTA Button -->
                        <div class="fade-in-up-delay-2 flex flex-wrap gap-5 justify-center lg:justify-start">
                            <a href="{{ route('register') }}" class="inline-flex items-center px-10 py-4 bg-[#166534] hover:bg-[#14532d] text-white font-bold rounded-2xl transition-all duration-300 group shadow-xl shadow-green-950/40">
                                Get Recommendation
                                <svg class="w-5 h-5 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right: Decorative Mortar Image -->
                    <div class="fade-in-up-delay-2 relative hidden lg:block">
                        <div class="relative z-10 rounded-[3rem] overflow-hidden border border-white/10 shadow-2xl shadow-black/50 float-animation">
                            <img src="{{ asset('images/hero-mortar-pretty.png') }}" alt="Herbal Wisdom" class="w-full h-full object-cover">
                            <div class="absolute bottom-8 left-8 right-8 p-6 bg-black/40 backdrop-blur-xl rounded-2xl border border-white/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-300 text-[10px] font-bold uppercase tracking-widest mb-1">Our Philosophy</p>
                                        <h4 class="text-white font-serif text-lg italic">Pure. Natural. Proven.</h4>
                                    </div>
                                    <div class="w-12 h-12 rounded-full bg-green-600/30 flex items-center justify-center text-2xl">🍃</div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -inset-4 bg-green-500/20 rounded-[3.5rem] blur-2xl -z-10"></div>
                    </div>
                </div>
            </div>

            <!-- Wave divider -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 60L48 55C96 50 192 40 288 42C384 44 480 58 576 65C672 72 768 72 864 67C960 62 1056 52 1152 50C1248 48 1344 54 1392 57L1440 60V120H0V60Z" fill="#fafdf7"/>
                </svg>
            </div>
        </section>

        <!-- ===== ABOUT SECTION ===== -->
        <section id="about" class="py-24 bg-[#fafdf7]">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-1.5 bg-green-100 rounded-full text-green-700 text-xs font-semibold tracking-wider uppercase mb-4">Our Approach</span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gray-900 mb-4">How HerbCare Works</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto font-sans">Personalized herbal recommendations powered by Traditional Chinese Medicine principles</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02] transition-all duration-500 float-animation">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition-colors duration-500">
                            <span class="text-2xl group-hover:scale-110 transition-transform">📋</span>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-3 group-hover:text-green-800 transition-colors">Describe Symptoms</h3>
                        <p class="text-gray-500 text-sm leading-relaxed font-sans">Share your symptoms with your practitioner for a personalized assessment based on TCM diagnostics.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-500 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02] float-animation" style="animation-delay: 2s;">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition-colors duration-500">
                            <span class="text-2xl group-hover:scale-110 transition-transform">🌿</span>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-3 group-hover:text-green-800 transition-colors">Get Herb Suggestions</h3>
                        <p class="text-gray-500 text-sm leading-relaxed font-sans">Receive tailored herbal recommendations with detailed preparation methods and dosage guidelines.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02] transition-all duration-500 float-animation" style="animation-delay: 4s;">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition-colors duration-500">
                            <span class="text-2xl group-hover:scale-110 transition-transform">💚</span>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-3 group-hover:text-green-800 transition-colors">Begin Healing</h3>
                        <p class="text-gray-500 text-sm leading-relaxed font-sans">Start your natural wellness journey with trusted, time-tested herbal remedies from centuries of TCM practice.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CONTACT SECTION ===== -->
        <section id="contact" class="py-32 bg-[#fafdf7] relative overflow-hidden">
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-100/20 rounded-full blur-[120px] -mb-48 -mr-48"></div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center relative z-10">
                <span class="inline-block px-4 py-1.5 bg-green-100 border border-green-200 rounded-full text-green-800 text-[10px] font-bold tracking-[0.2em] uppercase mb-6">Connect With Us</span>
                <h2 class="font-serif text-4xl sm:text-5xl font-bold text-gray-900 mb-8">Contact Us</h2>
                <p class="text-gray-600 text-lg max-w-xl mx-auto mb-16 font-light italic font-serif">"Have questions about our herbal formulations or need guidance on your TCM journey? Our team is here to support you."</p>

                <div class="grid sm:grid-cols-3 gap-8 text-left">
                    <!-- Email Card -->
                    <a href="mailto:kienfattmedicalstore@gmail.com" class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02] transition-all duration-500 float-animation">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition-colors duration-500">
                            <span class="text-2xl group-hover:scale-110 transition-transform">📧</span>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-3 group-hover:text-green-800 transition-colors">Email</h3>
                        <p class="text-gray-500 text-sm leading-relaxed font-sans break-all">kienfattmedicalstore@gmail.com</p>
                    </a>

                    <!-- WhatsApp Card -->
                    <a href="https://wa.me/60172185428" target="_blank" class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02] transition-all duration-500 float-animation" style="animation-delay: 2s;">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition-colors duration-500">
                            <svg class="w-8 h-8 text-green-700 group-hover:text-white group-hover:scale-110 transition-all duration-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.66-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-3 group-hover:text-green-800 transition-colors">WhatsApp</h3>
                        <p class="text-gray-500 text-sm leading-relaxed font-sans">+60 17-218 5428</p>
                    </a>

                    <!-- Official Store Card -->
                    <a href="https://www.kienfattmed.com" target="_blank" class="group bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02] transition-all duration-500 float-animation" style="animation-delay: 4s;">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition-colors duration-500">
                            <span class="text-2xl group-hover:scale-110 transition-transform">🏪</span>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-gray-900 mb-3 group-hover:text-green-800 transition-colors">Official Store</h3>
                        <p class="text-gray-500 text-sm leading-relaxed font-sans">www.kienfattmed.com</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== FOOTER ===== -->
        <footer class="bg-[#062c12] text-green-100/40 py-16 border-t border-green-800/30">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-10">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/logo.png') }}" alt="HerbCare" class="w-10 h-10 rounded-full object-cover shadow-lg border border-white/10" style="aspect-ratio:1/1;">
                        <div>
                            <span class="font-serif text-white font-bold text-xl tracking-tight">HerbCare</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-8 text-xs font-bold tracking-widest uppercase">
                        <a href="#" class="text-white/80 hover:text-white transition-colors">Privacy</a>
                        <a href="#" class="text-white/80 hover:text-white transition-colors">Terms</a>
                        <a href="#" class="text-white/80 hover:text-white transition-colors">Ethical Sourcing</a>
                        <a href="#contact" class="text-white/80 hover:text-white transition-colors">Contact</a>
                    </div>
                </div>
                <div class="border-t border-white/5 mt-12 pt-8 text-center text-[10px] tracking-widest uppercase text-white/40">
                    &copy; {{ date('Y') }} HerbCare. All rights reserved.
                </div>
            </div>
        </footer>

    </body>
</html>
