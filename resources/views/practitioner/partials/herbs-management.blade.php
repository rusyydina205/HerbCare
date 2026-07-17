<div class="space-y-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <p class="text-[10px] font-black text-[#064e3b]/40 uppercase tracking-[0.2em] mb-1">Clinic Inventory</p>
            <h3 class="text-2xl sm:text-3xl font-serif font-bold text-[#0f2818]">Manage Herbs List</h3>
        </div>
        
        <div class="w-full sm:w-auto">
            <form action="{{ route('practitioner.dashboard') }}" method="GET" class="relative group">
                <input type="hidden" name="tab" value="herbs">
                <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-gray-400 group-focus-within:text-[#064e3b]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search herbs..." 
                       class="w-full lg:w-56 pl-11 pr-5 py-3.5 bg-white border-2 border-gray-100 rounded-2xl text-xs font-bold focus:border-[#064e3b] focus:ring-0 transition-all shadow-sm group-hover:border-gray-200">
            </form>
        </div>
    </div>

    <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-green-900/[0.03] border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-green-900/[0.08]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Herb Name</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Classification</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Herb Information</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($herbs as $herb)
                        <tr class="hover:bg-green-50/30 transition-all duration-300 group text-sm">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="relative flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <img src="{{ $herb->image ? asset($herb->image) : asset('images/herb1.jpg') }}" 
                                             class="w-14 h-14 rounded-2xl object-cover border-2 border-white shadow-lg group-hover:shadow-green-900/10" alt="">
                                        <div class="absolute inset-0 rounded-2xl shadow-inner-sm"></div>
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#0f2818] leading-tight text-base">{{ $herb->herbName }}</p>
                                        <p class="text-[10px] italic text-[#064e3b] font-black uppercase tracking-widest mt-1 opacity-60 group-hover:opacity-100 transition-opacity">{{ $herb->scientificName }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="inline-flex items-center px-4 py-1.5 bg-[#e0efdb] text-[#064e3b] text-[10px] font-black rounded-full uppercase tracking-widest border border-[#c4e0b9] shadow-sm">
                                    {{ strtoupper($herb->category->categoryName ?? 'UNSET') }}
                                </span>
                            </td>
                            <td class="px-10 py-6">
                                <div class="max-w-[240px]">
                                    <p class="text-xs text-gray-500 font-medium line-clamp-2 leading-relaxed italic">
                                        "{{ $herb->benefits }}"
                                    </p>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <div class="flex items-center justify-end gap-3 transition-opacity duration-300">
                                    <button onclick="editHerb({{ json_encode($herb) }})" class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm hover:-translate-y-1" title="Edit Clinical Record">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('practitioner.herbs.destroy', $herb->herbId) }}" method="POST" onsubmit="return confirm('Archive this clinical record?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm hover:-translate-y-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-10 py-32 text-center border-none">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-200 mb-6 shadow-inner">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <p class="text-gray-400 font-serif italic text-lg">No clinical records found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
            <div class="text-xs font-bold text-gray-500">
                Showing <span class="text-[#064e3b]">{{ $herbs->firstItem() ?? 0 }}</span> to <span class="text-[#064e3b]">{{ $herbs->lastItem() ?? 0 }}</span> of <span class="text-[#064e3b]">{{ $herbs->total() }}</span> results
            </div>
            <div class="flex items-center">
                {{ $herbs->links() }}
            </div>
        </div>
    </div>
</div>
