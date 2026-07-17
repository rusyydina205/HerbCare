<x-app-layout>
    <x-slot name="header">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Work+Sans:wght@300;400;500&display=swap');
            .font-playfair { font-family: 'Playfair Display', serif; }
            .font-work { font-family: 'Work Sans', sans-serif; }
        </style>
        <div class="flex items-center gap-6">
            <a href="{{ $backRoute ?? route('dashboard') }}" class="p-3 bg-[#0f2818] text-white border border-[#0f2818]/20 rounded-2xl hover:bg-[#1a4d2e] shadow-sm transition-all hover:shadow-md active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-playfair font-bold text-xl text-[#0f2818] leading-tight tracking-wide">
                {{ __('Contact Us') }}
            </h2>
        </div>
    </x-slot>

    <section class="py-10 md:py-16 bg-[#fafdf7] min-h-screen font-work border-t border-green-900/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header section -->
            <div class="text-center mb-10">
                <h1 class="text-2xl md:text-3xl font-playfair font-bold text-[#0f2818] mb-2">Get In Touch</h1>
                <p class="text-gray-500 max-w-xl mx-auto leading-relaxed text-[13px] md:text-sm">Contact us for expert consultation regarding herbs, remedies, or your orders.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-stretch">
                
                <!-- Left Side: Formal Connect Cards -->
                <div class="md:col-span-5 bg-[#0f2818] p-8 md:p-10 rounded-3xl md:rounded-[3.5rem] shadow-2xl border border-white/5 relative overflow-hidden h-full">
                    <!-- Subtle background decoration -->
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-green-500/10 rounded-full blur-[80px] -mr-32 -mb-32"></div>
                    
                    <h3 class="font-playfair font-bold text-2xl text-white mb-8 pb-4 border-b border-white/10 relative z-10">Contact Information</h3>

                    <div class="space-y-4 relative z-10 h-full">
                        <!-- Operating Hours -->
                        <div class="flex items-center gap-5 bg-white p-6 rounded-[2rem] shadow-sm border border-[#e0efdb] hover:border-[#166534] transition-all min-h-[110px] group">
                            <div class="w-12 h-12 flex-shrink-0 bg-[#e0efdb]/50 rounded-full flex items-center justify-center text-[#166534] group-hover:bg-[#166534] group-hover:text-white transition-all duration-500 group-hover:rotate-[360deg]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-[#0f2818] mb-0.5 uppercase text-[9px] tracking-widest opacity-60">Operating Hours</h4>
                                <p class="text-sm text-[#166534] font-bold leading-tight">Mon - Fri: 8am - 5pm</p>
                                <p class="text-[9px] text-gray-400 font-medium italic mt-1 leading-none">Reply as fast as possible</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <a href="mailto:kienfattmedicalstore@gmail.com" class="flex items-center gap-5 bg-white p-6 rounded-[2rem] shadow-sm border border-[#e0efdb] hover:shadow-md hover:border-[#166534] transition-all group min-h-[110px]">
                            <div class="w-12 h-12 flex-shrink-0 bg-[#e0efdb]/50 rounded-full flex items-center justify-center text-[#166534] group-hover:bg-[#166534] group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-[#0f2818] mb-0.5 text-sm">Email Support</h4>
                                <p class="text-[11px] text-gray-500 font-medium tracking-wide truncate max-w-[180px]">kienfattmedicalstore@gmail.com</p>
                            </div>
                        </a>

                        <!-- WhatsApp -->
                        <a href="https://wa.me/60172185428" target="_blank" class="flex items-center gap-5 bg-white p-6 rounded-[2rem] shadow-sm border border-[#e0efdb] hover:shadow-md hover:border-[#166534] transition-all group min-h-[110px]">
                            <div class="w-12 h-12 flex-shrink-0 bg-[#e0efdb]/50 rounded-full flex items-center justify-center text-[#166534] group-hover:bg-[#166534] group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.66-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-[#0f2818] mb-0.5 text-sm">WhatsApp</h4>
                                <p class="text-[11px] text-gray-500 font-medium tracking-wide">+60 17-218 5428</p>
                            </div>
                        </a>

                        <!-- Store Link -->
                        <a href="https://www.kienfattmed.com/" target="_blank" class="flex items-center gap-5 bg-white p-6 rounded-[2rem] shadow-sm border border-[#e0efdb] hover:shadow-md hover:border-[#166534] transition-all group min-h-[110px]">
                            <div class="w-12 h-12 flex-shrink-0 bg-[#e0efdb]/50 rounded-full flex items-center justify-center text-[#166534] group-hover:bg-[#166534] group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-[#0f2818] mb-0.5 text-sm">Official Store</h4>
                                <p class="text-[11px] text-gray-500 font-medium tracking-wide">www.kienfattmed.com</p>
                            </div>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/kienfattmedicalstore/" target="_blank" class="flex items-center gap-5 bg-white p-6 rounded-[2rem] shadow-sm border border-[#e0efdb] hover:shadow-md hover:border-[#166534] transition-all group min-h-[110px]">
                            <div class="w-12 h-12 flex-shrink-0 bg-[#e0efdb]/50 rounded-full flex items-center justify-center text-[#166534] group-hover:bg-[#166534] group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100-2.881 1.44 1.44 0 000 2.881z"/></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-[#0f2818] mb-0.5 text-sm">Instagram</h4>
                                <p class="text-[11px] text-gray-500 font-medium tracking-wide">@kienfattmedicalstore</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Right Side: Formal Contact Form -->
                <div class="md:col-span-7 bg-[#0f2818] p-8 md:p-12 rounded-3xl md:rounded-[3.5rem] shadow-2xl border border-white/5 relative overflow-hidden">
                    <!-- Subtle background decoration -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-green-500/10 rounded-full blur-[80px] -mr-32 -mt-32"></div>
                    
                    <h3 class="text-3xl font-playfair font-bold text-white mb-8 pb-4 border-b border-white/10 relative z-10">Direct Message</h3>
 
                    @if(session('status') === 'message-sent')
                        <div class="mb-8 p-6 bg-green-500/10 border border-green-500/20 text-green-300 rounded-[2rem] font-bold flex items-center gap-4 relative z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Your message has been received successfully. Our practitioner will respond within 24 hours during operating hours.
                        </div>
                    @endif
 
                    @if(session('error'))
                        <div class="mb-8 p-6 bg-red-500/10 border border-red-500/20 text-red-300 rounded-[2rem] font-bold flex items-center gap-4 relative z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif
 
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-8 relative z-10">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] font-extrabold text-green-400 uppercase tracking-[0.2em] mb-3 ml-2">Full Name</label>
                                <input type="text" class="w-full bg-white border-white/10 text-gray-900 text-sm rounded-2xl p-5 px-6 font-medium cursor-default focus:ring-0 focus:border-white/10" value="{{ auth()->check() ? auth()->user()->name : 'Guest User' }}" readonly title="Name is fixed to your account profile">
                            </div>
                            <div>
                                <label class="block text-[10px] font-extrabold text-green-400 uppercase tracking-[0.2em] mb-3 ml-2">Subject</label>
                                <input type="text" name="subject" class="w-full bg-white border-white/10 text-gray-900 text-sm rounded-2xl focus:ring-green-500 focus:border-green-500 block p-5 px-6 transition-all font-medium placeholder-gray-400" placeholder="Brief subject" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-extrabold text-green-400 uppercase tracking-[0.2em] mb-3 ml-2">How can we help?</label>
                            <textarea name="message" rows="5" class="w-full bg-white border-white/10 text-gray-900 text-sm rounded-2xl focus:ring-green-500 focus:border-green-500 block p-6 transition-all font-medium resize-none shadow-inner-sm placeholder-gray-400" placeholder="Describe your consultation needs or inquiries..." required></textarea>
                        </div>
 
                        <button type="submit" class="group relative w-full overflow-hidden text-[#0f2818] bg-[#e0efdb] hover:bg-[#166534] hover:text-white font-bold tracking-[0.2em] rounded-[1.5rem] text-xs px-6 py-6 text-center transition-all shadow-xl uppercase active:scale-[0.98]">
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                Send Inquiry
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
