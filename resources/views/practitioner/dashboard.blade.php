<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
              
                <h2 class="font-serif font-bold text-4xl text-white leading-tight">
                    Welcome, Practitioner
                </h2>
            </div>
            <div class="flex items-center gap-4">
                @if($newMessagesCount > 0)
                    <a href="{{ route('practitioner.messages.index') }}" class="relative inline-flex items-center justify-center w-14 h-14 bg-amber-500 text-[#064e3b] rounded-2xl hover:bg-amber-400 transition-all shadow-xl hover:-translate-y-0.5 active:scale-95 group animate-bounce hover:animate-none" title="You have {{ $newMessagesCount }} new patient inquiries">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 flex h-5 w-5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-5 w-5 bg-white text-[9px] font-black items-center justify-center text-[#064e3b]">{{ $newMessagesCount }}</span>
                        </span>
                    </a>
                @else
                    <a href="{{ route('practitioner.messages.index') }}" class="relative inline-flex items-center justify-center w-14 h-14 bg-white/10 text-white rounded-2xl hover:bg-white/20 transition-all border border-white/20 shadow-sm hover:-translate-y-0.5 active:scale-95 group" title="Patient Messages">
                        <svg class="w-6 h-6 text-green-200 opacity-60 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </a>
                @endif
                <button onclick="openHerbModal()" class="inline-flex items-center bg-white text-[#064e3b] font-bold py-4 px-8 rounded-2xl hover:bg-green-50 transition-all shadow-xl hover:-translate-y-0.5 active:scale-95 gap-3 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add New Herb
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Dashboard Content -->
    <div class="space-y-12">
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <x-practitioner-stat-card 
                title="Total Herbs" 
                :value="\App\Models\Herb::count()" 
                label="Total Herbs in Database" 
                icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                trend="+4%"
                accent="blue"
            />
            <x-practitioner-stat-card 
                title="Total Consultations" 
                :value="$totalConsultations" 
                label="Total Consultations" 
                icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                trend="+12%"
                accent="orange"
            />
            <x-practitioner-stat-card 
                title="Pending Inquiries" 
                :value="$newMessagesCount" 
                label="Awaiting Professional Reply" 
                icon="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                :is-alert="$newMessagesCount > 0"
                accent="pink"
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Side: Manage Herbs -->
            <div class="lg:col-span-8 space-y-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-[#064e3b]/40 uppercase tracking-[0.2em] mb-1">Clinic Inventory</p>
                        <h3 class="text-3xl font-serif font-bold text-[#0f2818]">Manage Herbs List</h3>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <form action="{{ route('practitioner.dashboard') }}" method="GET" class="relative group">
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
                                                <button type="button" data-herb='@json($herb)' onclick="editHerb(JSON.parse(this.dataset.herb))" class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm hover:-translate-y-1" title="Edit Clinical Record">
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
                    
                    {{-- Pagination Section Styled like the image --}}
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

            <!-- Right Side: Activity & Stats -->
            <div class="lg:col-span-4 space-y-12">
                <!-- Recent Patients List -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Recent Patients</h4>
                        <a href="{{ route('practitioner.patients.index') }}" class="text-[10px] font-black text-[#064e3b] uppercase tracking-widest hover:underline transition-colors">View All</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($recentUsers as $patient)
                            <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 group hover:border-[#064e3b]/20 transition-all">
                                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-[#064e3b] font-bold text-xs">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-[#0f2818] truncate">{{ $patient->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium truncate italic">{{ $patient->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Message Snapshot -->
                <div class="bg-[#064e3b] rounded-[3rem] p-8 text-white relative overflow-hidden shadow-2xl">
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="p-2 bg-white/10 rounded-xl">
                                <svg class="w-4 h-4 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            </span>
                            <h4 class="text-xs font-black uppercase tracking-widest">Recent Inquiries</h4>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentMessages as $msg)
                                <div class="border-l-2 border-white/20 pl-4 py-1">
                                    <p class="text-[10px] font-black text-green-200/60 uppercase tracking-wide mb-1">{{ $msg->patient->name }}</p>
                                    <p class="text-xs font-medium leading-relaxed line-clamp-1 opacity-80 italic">"{{ $msg->message }}"</p>
                                </div>
                            @empty
                                <p class="text-xs opacity-40 italic">No new messages.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('practitioner.messages.index') }}" class="mt-8 w-full inline-flex items-center justify-center bg-white text-[#064e3b] font-black py-4 rounded-2xl hover:bg-green-50 transition-all text-[10px] uppercase tracking-widest shadow-xl">
                            Go to Inbox
                        </a>
                    </div>
                    <!-- Decorative Circle -->
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
                </div>

                <!-- Active Practitioners List -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest">Active Practitioners</h4>
                    </div>
                    <div class="space-y-4">
                        @foreach($practitioners as $practitioner)
                            <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 group hover:border-[#064e3b]/20 transition-all">
                                <div class="relative flex-shrink-0">
                                    @if($practitioner->profile_photo)
                                        <img src="{{ asset('profile_photos/' . $practitioner->profile_photo) }}" alt="{{ $practitioner->name }}" class="w-10 h-10 rounded-xl object-cover shadow-sm border border-gray-100">
                                    @else
                                        <div class="w-10 h-10 bg-[#064e3b] text-white rounded-xl flex items-center justify-center font-bold shadow-sm text-xs">
                                            {{ strtoupper(substr($practitioner->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full shadow-sm"></div>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-[#0f2818] truncate group-hover:text-[#064e3b] transition-colors">{{ $practitioner->name }}</p>
                                    <p class="text-[10px] text-gray-500 font-medium truncate flex items-center gap-1 mt-0.5">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $practitioner->messages_count }} Replied
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Herb Management Modal (Add/Edit) -->
    <div id="herb-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-[#064e3b]/40 backdrop-blur-sm" onclick="closeHerbModal()"></div>
            
            <div class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-3xl rounded-[3rem] p-12 border border-gray-100 relative">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-3xl font-serif font-bold text-[#0f2818]" id="herb-modal-title">Add New Herb</h3>
                    <button onclick="closeHerbModal()" class="p-3 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="herb-form" action="{{ route('practitioner.herbs.store') }}" method="POST" class="space-y-10">
                    @csrf
                    <input type="hidden" name="_method" id="herb-form-method" value="POST">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block">Common Name</label>
                            <input type="text" name="herbName" id="modal-herbName" required class="w-full px-8 py-5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818]" placeholder="e.g. Ginseng">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block">Scientific Name</label>
                            <input type="text" name="scientificName" id="modal-scientificName" required class="w-full px-8 py-5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold italic text-[#0f2818]" placeholder="e.g. Panax ginseng">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="relative">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block">Category</label>
                            <select name="categoryId" id="modal-categoryId" required class="w-full px-8 py-5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818] appearance-none cursor-pointer">
                                <option value="" disabled selected>Select Classification</option>
                                @foreach(\App\Models\HealthCategory::all() as $cat)
                                    <option value="{{ $cat->categoryId }}">{{ $cat->categoryName }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-6 bottom-5 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block">Image Path</label>
                            <input type="text" name="image" id="modal-image" class="w-full px-8 py-5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all text-xs font-bold text-gray-500" placeholder="images/herbs/filename.jpg">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block">Therapeutic Benefits</label>
                            <textarea name="benefits" id="modal-benefits" rows="4" required class="w-full px-8 py-5 bg-gray-50 border-gray-100 rounded-[1.5rem] focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all text-sm font-medium text-gray-600" placeholder="Clinical indications and healing properties..."></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-10">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block">Preparation</label>
                                <textarea name="preparation" id="modal-preparation" rows="3" required class="w-full px-8 py-5 bg-gray-50 border-gray-100 rounded-[1.5rem] focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all text-xs font-medium text-gray-600" placeholder="Usage guidelines..."></textarea>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-orange-400 uppercase tracking-[0.2em] mb-3 block">Safety & Warning</label>
                                <textarea name="safety" id="modal-safety" rows="3" required class="w-full px-8 py-5 bg-orange-50 border-orange-100 rounded-[1.5rem] focus:bg-white focus:border-orange-500 focus:ring-orange-500 transition-all text-xs font-medium text-gray-600" placeholder="Contraindications..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block">Associated Symptoms</label>
                        <div class="bg-gray-50 border border-gray-100 rounded-[2rem] p-8 max-h-72 overflow-y-auto custom-scrollbar">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                @foreach($allSymptoms as $categoryName => $symptoms)
                                    <div class="space-y-4">
                                        <h5 class="text-[9px] font-black text-[#064e3b]/40 uppercase tracking-widest border-b border-green-100 pb-2">{{ $categoryName }}</h5>
                                        <div class="grid gap-3">
                                            @foreach($symptoms as $symptom)
                                                <label class="flex items-center gap-3 group cursor-pointer">
                                                    <div class="relative flex items-center justify-center">
                                                        <input type="checkbox" name="symptoms[]" value="{{ $symptom->symptomId }}" class="w-5 h-5 rounded-lg border-gray-200 text-[#064e3b] focus:ring-[#064e3b] transition-all cursor-pointer">
                                                    </div>
                                                    <span class="text-xs font-medium text-gray-600 group-hover:text-[#064e3b] transition-colors line-clamp-1">{{ $symptom->symptomName }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-10">
                        <button type="button" onclick="closeHerbModal()" class="flex-1 bg-gray-50 text-gray-500 font-bold py-5 rounded-[1.5rem] hover:bg-gray-100 transition-all border border-gray-100 uppercase tracking-widest text-xs">Cancel</button>
                        <button type="submit" class="flex-1 bg-[#064e3b] text-white font-bold py-5 rounded-[1.5rem] hover:bg-[#043327] transition-all shadow-xl active:scale-95 uppercase tracking-widest text-xs">Save Clinical Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openHerbModal() {
            document.getElementById('herb-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.getElementById('herb-form').action = "{{ route('practitioner.herbs.store') }}";
            document.getElementById('herb-form-method').value = "POST";
            document.getElementById('herb-modal-title').innerText = "Add New Herb";
            document.getElementById('modal-herbName').value = "";
            document.getElementById('modal-scientificName').value = "";
            document.getElementById('modal-categoryId').value = "";
            document.getElementById('modal-image').value = "";
            document.getElementById('modal-benefits').value = "";
            document.getElementById('modal-preparation').value = "";
            document.getElementById('modal-safety').value = "";

            // Reset symptoms
            document.querySelectorAll('input[name="symptoms[]"]').forEach(cb => cb.checked = false);
        }

        function closeHerbModal() {
            document.getElementById('herb-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function editHerb(herb) {
            document.getElementById('herb-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.getElementById('herb-form').action = "/practitioner/herbs/" + herb.herbId;
            document.getElementById('herb-form-method').value = "PUT";
            document.getElementById('herb-modal-title').innerText = "Edit " + herb.herbName;
            
            document.getElementById('modal-herbName').value = herb.herbName;
            document.getElementById('modal-scientificName').value = herb.scientificName;
            document.getElementById('modal-categoryId').value = herb.categoryId;
            document.getElementById('modal-image').value = herb.image || "";
            document.getElementById('modal-benefits').value = herb.benefits;
            document.getElementById('modal-preparation').value = herb.preparation;
            document.getElementById('modal-safety').value = herb.safety;

            // Set symptoms
            const symptomIds = herb.symptoms.map(s => s.symptomId);
            document.querySelectorAll('input[name="symptoms[]"]').forEach(cb => {
                cb.checked = symptomIds.includes(parseInt(cb.value));
            });
        }
    </script>
</x-app-layout>
