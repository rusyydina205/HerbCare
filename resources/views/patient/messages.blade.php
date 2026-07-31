<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gray-100/80 p-6 rounded-[2rem] border border-gray-200 shadow-sm">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="p-4 bg-gray-200 text-[#064e3b] rounded-2xl hover:bg-gray-300 transition-all border border-gray-300 shadow-sm" title="Back to Dashboard">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <p class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-1">HerbCare Consultation</p>
                    <h2 class="font-serif font-bold text-2xl sm:text-4xl text-[#064e3b] leading-tight">New Consultation Update</h2>
                </div>
            </div>

            {{-- Summary Stats --}}
            <div class="flex items-center gap-3">
                @php
                    $unreadCount = $messages->where('is_read', false)->whereNotNull('reply')->count();
                @endphp
                <div class="flex items-center gap-2 px-6 py-3 bg-[#e0efdb] text-[#064e3b] rounded-2xl border border-white/20 shadow-lg">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 {{ $unreadCount > 0 ? 'animate-pulse' : '' }}"></span>
                    <span class="text-xs font-black uppercase tracking-widest">{{ $unreadCount }} NEW REPLIES</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-10 bg-green-50 border border-green-100 text-[#064e3b] px-8 py-5 rounded-[2rem] shadow-sm flex items-center gap-4 animate-in fade-in slide-in-from-top-4">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        @endif

        @if($messages->isEmpty())
            <div class="max-w-3xl mx-auto mt-8">
                <div class="bg-white rounded-[4rem] p-16 sm:p-32 text-center border border-gray-100 shadow-2xl shadow-green-900/[0.05]">
                    <div class="w-28 h-28 bg-[#f2f9f0] rounded-[2.5rem] flex items-center justify-center mx-auto mb-10 shadow-inner">
                        <svg class="w-12 h-12 text-[#064e3b]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <h3 class="text-3xl font-serif font-bold text-[#0f2818] mb-6">Start a Consultation</h3>
                    <p class="text-gray-400 max-w-md mx-auto leading-relaxed text-sm mb-12">Your health is our priority. Send us an inquiry about any symptoms or herbs, and our practitioners will provide professional guidance.</p>
                    <a href="{{ route('contact') }}" class="inline-flex px-12 py-5 bg-[#064e3b] text-white text-[11px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#08634a] transition-all shadow-2xl hover:-translate-y-1 active:scale-95">Send Your First Inquiry</a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                {{-- Main Content: Messages --}}
                <div class="lg:col-span-8 space-y-16">
                @foreach($messages as $msg)
                <div class="relative group">
                    <div class="bg-white rounded-3xl sm:rounded-[3.5rem] shadow-2xl shadow-green-900/[0.03] border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-green-900/[0.08]">
                        
                        {{-- Message Header --}}
                        <div class="px-6 sm:px-12 py-8 sm:py-10 bg-gray-50/50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-6">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-[#064e3b] rounded-2xl flex items-center justify-center text-white shadow-xl shadow-green-900/20">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-serif font-bold text-[#0f2818] tracking-tight">{{ $msg->subject }}</h3>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mt-1">Reference ID #{{ $msg->messageId }} • Sent on {{ $msg->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                @if(!$msg->is_read && $msg->reply)
                                    <span class="px-5 py-2 bg-amber-400 text-[#064e3b] text-[10px] font-black uppercase tracking-widest rounded-full shadow-md animate-pulse">New Reply</span>
                                @endif
                                <span class="px-5 py-2 {{ $msg->status === 'resolved' ? 'bg-[#064e3b] text-white' : ($msg->status === 'replied' ? 'bg-blue-500 text-white' : 'bg-amber-100 text-amber-700') }} text-[10px] font-black uppercase tracking-widest rounded-full border border-transparent shadow-sm">
                                    {{ ucfirst($msg->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 sm:p-12 space-y-12">
                            {{-- Patient Inquiry --}}
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-8">
                                <div class="shrink-0">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 border border-gray-200 flex items-center justify-center text-[11px] font-black text-gray-400 uppercase tracking-widest">YOU</div>
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-50/50 rounded-2xl sm:rounded-[2.5rem] p-6 sm:p-10 border border-gray-100 relative shadow-sm">
                                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed font-medium italic whitespace-pre-wrap">"{{ $msg->message }}"</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Practitioner's Response --}}
                            @if($msg->reply)
                                <div class="flex flex-col sm:flex-row gap-4 sm:gap-8 items-start">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-2xl bg-[#e0efdb] border border-[#c4e0b9] flex items-center justify-center text-[11px] font-black text-[#064e3b] uppercase tracking-widest shadow-sm">DR</div>
                                    </div>
                                    <div class="flex-1 space-y-6 w-full">
                                        <div class="bg-[#f2f9f0] rounded-2xl sm:rounded-[2.5rem] p-6 sm:p-10 border-2 border-[#e0efdb] relative shadow-lg shadow-green-900/5 group/reply">
                                            <div class="flex items-center justify-between mb-6">
                                                <p class="text-[10px] font-black text-[#064e3b]/60 uppercase tracking-[0.2em]">Practitioner Reply • {{ \Carbon\Carbon::parse($msg->replied_at)->format('d M Y, H:i') }}</p>
                                                @if(!$msg->is_read)
                                                    <button onclick="markAsRead({{ $msg->messageId }})" class="flex items-center gap-2 text-[10px] font-black text-[#064e3b] uppercase tracking-widest hover:underline decoration-2 underline-offset-4">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                        Mark as Read
                                                    </button>
                                                @else
                                                    <span class="flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                        Read
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-base sm:text-lg text-[#0f2818] leading-relaxed font-medium">
                                                {{ $msg->reply }}
                                            </p>
                                        </div>

                                        {{-- Follow-up Reply Form --}}
                                        <div class="pt-4 px-6">
                                            <button onclick="toggleReplyForm({{ $msg->messageId }})" class="flex items-center gap-3 text-[#064e3b] hover:text-[#08634a] transition-colors group/replybtn">
                                                <div class="w-10 h-10 bg-[#e0efdb] rounded-xl flex items-center justify-center group-hover/replybtn:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                                </div>
                                                <span class="text-xs font-black uppercase tracking-widest">Ask a follow-up question</span>
                                            </button>

                                            <form id="reply-form-{{ $msg->messageId }}" action="{{ route('patient.messages.reply', $msg->messageId) }}" method="POST" class="hidden mt-8 space-y-6 animate-in slide-in-from-top-4 duration-500">
                                                @csrf
                                                <div class="relative">
                                                    <textarea name="message" rows="4" required
                                                              class="w-full bg-white border-2 border-gray-100 rounded-2xl sm:rounded-[2rem] p-6 sm:p-8 text-sm focus:border-[#064e3b] focus:ring-0 transition-all shadow-inner"
                                                              placeholder="Type your question here..."></textarea>
                                                </div>
                                                <div class="flex justify-end gap-4">
                                                    <button type="button" onclick="toggleReplyForm({{ $msg->messageId }})" class="px-8 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600">Cancel</button>
                                                    <button type="submit" class="px-10 py-4 bg-[#064e3b] text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#08634a] transition-all shadow-xl active:scale-95">Send Question</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex gap-8 items-center py-10 opacity-60">
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-[11px] font-black text-gray-300">DR</div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex gap-1">
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#064e3b] animate-bounce"></div>
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#064e3b] animate-bounce [animation-delay:0.2s]"></div>
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#064e3b] animate-bounce [animation-delay:0.4s]"></div>
                                        </div>
                                        <p class="text-sm font-serif italic text-gray-400 tracking-wide">Our practitioner is reviewing your inquiry. We'll update you shortly.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

            @if($messages->hasPages())
                <div class="pt-10 flex justify-center">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
            </div>

            {{-- Sidebar: Active Practitioners --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-2xl shadow-green-900/[0.03]">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-[#064e3b] shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-serif font-bold text-[#0f2818]">Our Practitioners</h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-0.5">Ready to assist you</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        @foreach($practitioners as $practitioner)
                            <div class="group flex items-center justify-between p-4 rounded-2xl hover:bg-[#f2f9f0] border border-transparent hover:border-[#e0efdb] transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        @if($practitioner->profile_photo)
                                            <img src="{{ asset('profile_photos/' . $practitioner->profile_photo) }}" alt="{{ $practitioner->name }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-[#064e3b] text-white rounded-xl flex items-center justify-center font-bold shadow-sm">
                                                {{ strtoupper(substr($practitioner->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-[#0f2818] group-hover:text-[#064e3b] transition-colors">{{ $practitioner->name }}</h4>
                                        <p class="text-[11px] font-medium text-gray-500 flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $practitioner->messages_count }} Consultations Replied
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        function markAsRead(id) {
            fetch(`/messages/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                }
            });
        }

        function toggleReplyForm(id) {
            const form = document.getElementById(`reply-form-${id}`);
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                form.querySelector('textarea').focus();
            }
        }
    </script>
</x-app-layout>
