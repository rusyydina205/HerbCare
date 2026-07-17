<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="p-4 bg-[#064e3b] border border-[#064e3b] text-white hover:bg-[#053d30] rounded-2xl hover:shadow-md transition-all shadow-sm" title="Back to Dashboard">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="font-serif font-bold text-2xl sm:text-4xl text-[#0f2818] leading-tight">HERB HISTORY</h2>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2 px-6 py-3 bg-[#e0efdb] text-[#0f2818] rounded-2xl border border-[#c4e0b9] shadow-sm">
                    <svg class="w-4 h-4 text-[#0f2818]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span class="text-xs font-black uppercase tracking-widest">{{ $history->total() }} Records</span>
                </div>
                <a href="{{ route('patient.history.pdf') }}" target="_blank" rel="noreferrer noopener" class="inline-flex items-center gap-2 px-6 py-3 bg-[#0f2818] text-white rounded-2xl border border-[#0f2818] shadow-sm hover:bg-[#153e30] transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7m5 4h4m-4 4h4m-6-6h8a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h2"/></svg>
                    Save as PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="space-y-6">
            @forelse($history as $item)
                <div class="bg-white rounded-3xl border border-gray-100 shadow-md hover:shadow-xl transition-all duration-300 p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    
                    {{-- Left side: Date & Symptom Info --}}
                    <div class="flex items-start gap-5 flex-1 min-w-0">
                        <div class="w-14 h-14 bg-[#0f2818] rounded-2xl flex flex-col items-center justify-center text-white shrink-0 shadow-lg shadow-green-900/10">
                            <span class="text-[10px] font-black uppercase tracking-wider leading-none">{{ $item->updated_at->format('M') }}</span>
                            <span class="text-xl font-bold leading-none mt-1">{{ $item->updated_at->format('d') }}</span>
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2.5 mb-1.5">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $item->updated_at->format('h:i A') }}</span>
                                @if($item->category)
                                    <span class="text-[9px] font-bold px-2 py-0.5 bg-[#e0efdb] text-[#0f2818] rounded-full border border-[#c4e0b9]">{{ $item->category->categoryName }}</span>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-[#0f2818] truncate mb-1">
                                Selected Symptom: <span class="text-green-700">{{ $item->symptom ? $item->symptom->symptomName : 'General Consultation' }}</span>
                            </h3>
                            <p class="text-xs text-gray-500 leading-relaxed max-w-xl">
                                These herb recommendations are based on your selected symptom and traditional herbal matching.
                            </p>
                        </div>
                    </div>

                    {{-- Right side: Recommended Herb Card --}}
                    <div class="w-full md:w-auto shrink-0 flex items-center gap-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100 min-w-[300px]">
                        @if($item->herb && $item->herb->image)
                            <img src="{{ $item->herb->image }}" alt="{{ $item->herbName }}" class="w-16 h-16 rounded-xl object-cover border border-gray-200 shrink-0">
                        @else
                            <div class="w-16 h-16 bg-[#e0efdb] rounded-xl flex items-center justify-center shrink-0 border border-gray-200">
                                <svg class="w-6 h-6 text-[#0f2818]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3s4 0 8 4c4 4 4 9 4 9s-4 0-8-4S5 3 5 3z"/></svg>
                            </div>
                        @endif
                        <div class="flex-grow min-w-0">
                            <h4 class="text-sm font-bold text-[#0f2818] truncate">{{ $item->herbName }}</h4>
                            <p class="text-[11px] text-gray-400 italic truncate mb-2">{{ $item->herb ? $item->herb->scientificName : 'TCM Herbal Remedy' }}</p>
                            @if($item->herb)
                                <a href="{{ route('herb.show', $item->herbsId) }}" class="inline-flex items-center gap-1.5 text-xs font-bold px-4 py-2 bg-[#0f2818] hover:bg-[#1a4d2e] text-white rounded-xl shadow-sm transition-all active:scale-95">
                                    View Details
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @else
                                <span class="text-xs text-gray-400 font-medium italic">Details unavailable</span>
                            @endif
                        </div>
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-[4rem] p-32 text-center border border-gray-100 shadow-xl shadow-green-900/[0.03]">
                    <div class="w-28 h-28 bg-[#e0efdb]/50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-10 shadow-inner border border-[#c4e0b9]">
                        <svg class="w-12 h-12 text-[#0f2818]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h3 class="text-3xl font-serif font-bold text-[#0f2818] mb-6">No Recommendations Yet</h3>
                    <p class="text-gray-400 max-w-md mx-auto leading-relaxed text-sm mb-12">Select your symptoms on the dashboard to receive tailored traditional herbal recommendations.</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex px-12 py-5 bg-[#0f2818] text-white text-[11px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#1a4d2e] transition-all shadow-2xl hover:-translate-y-1 active:scale-95">Go to Dashboard</a>
                </div>
            @endforelse

            @if($history->hasPages())
                <div class="pt-10 flex justify-center">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
