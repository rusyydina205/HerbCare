<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('practitioner.dashboard') }}" class="p-4 bg-white/10 text-white rounded-2xl hover:bg-white/20 transition-all border border-white/20 shadow-sm" title="Back to Dashboard">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-1">Welcome, Practitioner</p>
                    <h2 class="font-serif font-bold text-4xl text-white leading-tight">Patient Messages</h2>
                </div>
            </div>

            {{-- Stats chips --}}
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-400/20 text-amber-200 rounded-2xl border border-amber-400/20 text-xs font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    {{ $pendingCount }} Pending
                </span>
                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-400/20 text-blue-200 rounded-2xl border border-blue-400/20 text-xs font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                    {{ $repliedCount }} Replied
                </span>
                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-400/20 text-green-200 rounded-2xl border border-green-400/20 text-xs font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    {{ $resolvedCount }} Resolved
                </span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- Flash success --}}
        @if (session('status') === 'message-status-updated')
            <div id="flash-msg" class="flex items-center gap-4 bg-green-50 border border-green-200 text-green-800 px-8 py-5 rounded-2xl shadow-sm text-sm font-bold">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Message status updated successfully.
                <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-green-400 hover:text-green-600 transition-colors">✕</button>
            </div>
        @endif

        {{-- Search + Filter --}}
        <div class="flex flex-col md:flex-row md:items-center gap-4">
            {{-- Search bar --}}
            <div class="relative group w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-gray-400 group-focus-within:text-[#064e3b]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <form action="{{ route('practitioner.messages.index') }}" method="GET" id="search-form">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search patient, subject or message..."
                           class="w-full pl-12 pr-10 py-4 bg-white border-gray-100 rounded-2xl text-sm focus:border-[#064e3b] focus:ring-[#064e3b] transition-all shadow-sm">
                    @if(request('search'))
                        <a href="{{ route('practitioner.messages.index', ['status' => request('status')]) }}"
                           class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors text-lg font-bold">✕</a>
                    @endif
                </form>
            </div>

            {{-- Status filter tabs --}}
            <div class="flex flex-wrap gap-3">
            @php $filterStatus = request('status', ''); @endphp
            <a href="{{ route('practitioner.messages.index') }}"
               class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all border
                      {{ $filterStatus === '' ? 'bg-white text-[#064e3b] border-transparent shadow-md' : 'bg-white/10 text-white/60 border-white/10 hover:bg-white/20' }}">
                All
            </a>
            <a href="{{ route('practitioner.messages.index', ['status' => 'pending']) }}"
               class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all border
                      {{ $filterStatus === 'pending' ? 'bg-amber-400 text-[#064e3b] border-transparent shadow-md' : 'bg-white/10 text-white/60 border-white/10 hover:bg-white/20' }}">
                Pending
            </a>
            <a href="{{ route('practitioner.messages.index', ['status' => 'replied']) }}"
               class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all border
                      {{ $filterStatus === 'replied' ? 'bg-blue-400 text-[#064e3b] border-transparent shadow-md' : 'bg-white/10 text-white/60 border-white/10 hover:bg-white/20' }}">
                Replied
            </a>
            <a href="{{ route('practitioner.messages.index', ['status' => 'resolved']) }}"
               class="px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all border
                      {{ $filterStatus === 'resolved' ? 'bg-green-400 text-[#064e3b] border-transparent shadow-md' : 'bg-white/10 text-white/60 border-white/10 hover:bg-white/20' }}">
                Resolved
            </a>
            </div>{{-- end filter tabs --}}
        </div>{{-- end search+filter wrapper --}}

        {{-- Messages Table --}}
        <div class="bg-white rounded-[3rem] shadow-xl shadow-green-900/[0.02] border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Patient</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Subject &amp; Message</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-center">Status</th>
                        <th class="px-6 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Date</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($messages as $msg)
                        <tr class="hover:bg-green-50/20 transition-all group" id="row-{{ $msg->messageId }}">
                            {{-- Patient Info --}}
                            <td class="px-10 py-7">
                                <div class="flex items-center gap-4">
                                    @php
                                        $name   = $msg->patient?->name ?? 'Unknown Patient';
                                        $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=064e3b&background=e0efdb&size=80';
                                    @endphp
                                    <img src="{{ $avatar }}" alt="{{ $name }}" class="w-11 h-11 rounded-2xl object-cover border border-green-100 shadow-sm">
                                    <div>
                                        <p class="text-sm font-bold text-[#0f2818]">{{ $name }}</p>
                                        <p class="text-xs text-gray-400 font-medium">Patient #{{ $msg->patientId }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Subject & Message --}}
                            <td class="px-6 py-7 max-w-xs">
                                <p class="text-sm font-bold text-[#0f2818] mb-1 line-clamp-1">{{ $msg->subject }}</p>
                                <p class="text-xs text-gray-400 leading-relaxed line-clamp-2">{{ $msg->message }}</p>
                                <button onclick="openMessage({{ json_encode(['id' => $msg->messageId, 'name' => $name, 'subject' => $msg->subject, 'message' => $msg->message, 'date' => $msg->created_at?->format('d M Y, H:i')]) }})"
                                        class="mt-2 text-[10px] font-black text-[#064e3b]/60 uppercase tracking-widest hover:text-[#064e3b] transition-colors">
                                    Read full →
                                </button>
                            </td>

                            {{-- Status badge --}}
                            <td class="px-6 py-7 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'replied' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'resolved' => 'bg-green-100 text-green-700 border-green-200',
                                    ];
                                    $dotClasses = [
                                        'pending' => 'bg-amber-500',
                                        'replied' => 'bg-blue-500',
                                        'resolved' => 'bg-green-500',
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusClasses[$msg->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClasses[$msg->status] ?? 'bg-gray-500' }}"></span>
                                    {{ ucfirst($msg->status) }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-7 text-right">
                                <p class="text-xs font-semibold text-gray-500">{{ $msg->created_at?->format('d M Y') }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $msg->created_at?->format('H:i') }}</p>
                            </td>

                            {{-- Action --}}
                            <td class="px-10 py-7 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="openMessage({{ json_encode(['id' => $msg->messageId, 'name' => $name, 'subject' => $msg->subject, 'message' => $msg->message, 'date' => $msg->created_at?->format('d M Y, H:i'), 'reply' => $msg->reply, 'status' => $msg->status]) }})"
                                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#064e3b] text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#08634a] transition-all shadow-sm active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                        {{ $msg->reply ? 'View Reply' : 'Reply' }}
                                    </button>

                                    <form action="{{ route('practitioner.messages.status', $msg->messageId) }}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('PATCH')
                                        @if ($msg->status !== 'resolved')
                                            <input type="hidden" name="status" value="resolved">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-green-700 transition-all shadow-sm active:scale-95"
                                                    title="Mark as Resolved">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Resolve
                                            </button>
                                        @else
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-amber-600 transition-all shadow-sm active:scale-95"
                                                    title="Revert to Pending">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                Revert
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                    </div>
                                    <p class="text-gray-400 font-serif italic text-lg">No messages found.</p>
                                    @if(request('status'))
                                        <a href="{{ route('practitioner.messages.index') }}" class="text-[#064e3b] text-xs font-bold underline underline-offset-4">View all messages</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($messages->hasPages())
                <div class="px-10 py-8 border-t border-gray-100 bg-gray-50/30">
                    {{ $messages->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Read & Reply Message Modal --}}
    <div id="msg-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-12">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeMessage()"></div>
            <div class="relative w-full max-w-2xl bg-white rounded-[3rem] shadow-2xl p-12 border border-gray-100 z-10">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2" id="modal-patient-name">Patient</p>
                        <h3 class="text-2xl font-serif font-bold text-[#0f2818]" id="modal-subject">Subject</h3>
                        <p class="text-xs text-gray-400 mt-1" id="modal-date"></p>
                    </div>
                    <button onclick="closeMessage()" class="p-3 text-gray-400 hover:text-gray-600 transition-colors rounded-xl hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="space-y-8">
                    {{-- Patient's Message --}}
                    <div>
                        <p class="text-[10px] font-black text-green-600/60 uppercase tracking-widest mb-3">Patient Inquiry</p>
                        <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100">
                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap" id="modal-message"></p>
                        </div>
                    </div>

                    {{-- Reply Section --}}
                    <div id="reply-section">
                        <p class="text-[10px] font-black text-[#064e3b]/60 uppercase tracking-widest mb-3" id="reply-label">Your Reply</p>
                        
                        {{-- Existing Reply (View Mode) --}}
                        <div id="existing-reply" class="hidden">
                            <div class="bg-green-50 rounded-2xl p-8 border border-green-100">
                                <p class="text-sm text-[#064e3b] leading-relaxed whitespace-pre-wrap" id="modal-reply-content"></p>
                            </div>
                        </div>

                        {{-- Reply Form (Edit Mode) --}}
                        <form id="reply-form" action="" method="POST" class="hidden">
                            @csrf
                            <textarea name="reply" rows="5" required
                                      placeholder="Write your reply here..."
                                      class="w-full bg-white border-gray-100 rounded-2xl text-sm focus:border-[#064e3b] focus:ring-[#064e3b] transition-all shadow-sm mb-4"></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="px-8 py-3 bg-[#064e3b] text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-[#08634a] transition-all shadow-sm active:scale-95">
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openMessage(data) {
            document.getElementById('modal-patient-name').textContent = data.name;
            document.getElementById('modal-subject').textContent      = data.subject;
            document.getElementById('modal-date').textContent         = data.date;
            document.getElementById('modal-message').textContent      = data.message;
            
            const replyForm = document.getElementById('reply-form');
            const existingReply = document.getElementById('existing-reply');
            const replyLabel = document.getElementById('reply-label');

            if (data.reply) {
                // Show existing reply
                existingReply.classList.remove('hidden');
                replyForm.classList.add('hidden');
                document.getElementById('modal-reply-content').textContent = data.reply;
                replyLabel.textContent = "Your Previous Reply";
            } else {
                // Show reply form
                existingReply.classList.add('hidden');
                replyForm.classList.remove('hidden');
                replyForm.action = `/practitioner/messages/${data.id}/reply`;
                replyLabel.textContent = "Send New Reply";
            }

            document.getElementById('msg-modal').classList.remove('hidden');
        }
        function closeMessage() {
            document.getElementById('msg-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
