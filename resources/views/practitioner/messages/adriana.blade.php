<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-gray-100/80 p-6 rounded-[2rem] border border-gray-200 shadow-sm">
            <div class="flex items-center gap-6">
                <a href="{{ route('practitioner.dashboard') }}" class="p-4 bg-gray-200 text-[#064e3b] rounded-2xl hover:bg-gray-300 transition-all border border-gray-300 shadow-sm" title="Back to Dashboard">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <p class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-1">HerbCare Consultation</p>
                    <h2 class="font-serif font-bold text-2xl sm:text-4xl text-[#064e3b] leading-tight">New Consultation Update</h2>
                </div>
            </div>

            {{-- Summary Stats (reuse patient view's unread count logic) --}}
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

    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="space-y-16">
            @forelse($messages as $msg)
                <div class="relative group">
                    <div class="bg-white rounded-3xl sm:rounded-[3.5rem] shadow-2xl shadow-green-900/[0.03] border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-green-900/[0.08]">
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
            @empty
                <div class="bg-white rounded-[4rem] p-32 text-center border border-gray-100 shadow-2xl shadow-green-900/[0.05]">
                    <div class="w-28 h-28 bg-[#f2f9f0] rounded-[2.5rem] flex items-center justify-center mx-auto mb-10 shadow-inner">
                        <svg class="w-12 h-12 text-[#064e3b]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <h3 class="text-3xl font-serif font-bold text-[#0f2818] mb-6">Start a Consultation</h3>
                    <p class="text-gray-400 max-w-md mx-auto leading-relaxed text-sm mb-12">Your health is our priority. Send us an inquiry about any symptoms or herbs, and our practitioners will provide professional guidance.</p>
                    <a href="{{ route('contact') }}" class="inline-flex px-12 py-5 bg-[#064e3b] text-white text-[11px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#08634a] transition-all shadow-2xl hover:-translate-y-1 active:scale-95">Send Your First Inquiry</a>
                </div>
            @endforelse

            @if($messages->hasPages())
                <div class="pt-10 flex justify-center">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
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
    </script>
</x-app-layout>
