<x-app-layout>
    <div class="bg-[#fafdf7] min-h-screen" style="padding-bottom: 2rem;">

        <!-- Herb Recommendation Banner (below navbar) -->
        <div class="bg-[#fafdf7] border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 py-5">
                    <div class="flex items-center gap-4">
                        <!-- Icon -->
                        <div class="w-10 h-10 bg-[#064e3b] rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-[#1a1a1a] leading-tight">Welcome, {{ auth()->user()->name ?? 'Patient' }}</h1>
                            <p class="text-xs font-bold text-gray-500 tracking-widest uppercase mt-0.5">Ontology-Based Herb Recommendation</p>
                        </div>
                    </div>
                    <!-- How It Works Button -->
                    <button type="button" onclick="document.getElementById('howItWorksModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#eaf1ea] text-[#064e3b] rounded-full text-[13px] font-bold tracking-wide hover:bg-[#dce6dc] transition-colors shrink-0 shadow-sm">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        HOW IT WORKS
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

            <form method="GET" action="{{ route('dashboard') }}" id="filterForm" class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left Sidebar: Filters -->
                <div class="w-full lg:w-1/3 xl:w-[320px] shrink-0 bg-[#064e3b] text-white rounded-[24px] shadow-xl border border-[#053d30] p-6 flex flex-col h-fit">
                    <div class="flex items-center gap-2 text-white font-bold text-lg mb-8">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Preferences
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-10">
                        <h3 class="font-bold text-[15px] text-white mb-1">1. Select Category <span class="text-green-200 font-normal text-[13px]">(Optional)</span></h3>
                        <p class="text-[13px] text-green-100 mb-4">Choose a health category to narrow down symptoms.</p>
                        
                        <div class="grid grid-cols-2 gap-2.5">
                            <label class="cursor-pointer">
                                <input type="radio" name="category" value="" class="hidden peer" onchange="this.form.submit()" {{ request('category') == '' ? 'checked' : '' }}>
                                <div class="px-2 py-3 border border-transparent bg-[#053d30] rounded-xl text-[12px] font-bold text-green-50 text-center peer-checked:border-white peer-checked:text-[#064e3b] peer-checked:bg-white transition-all flex flex-col items-center justify-center gap-2 h-full hover:bg-white/10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    All Categories
                                </div>
                            </label>
                            @foreach($categories as $cat)
                            <label class="cursor-pointer">
                                <input type="radio" name="category" value="{{ $cat->categoryId }}" class="hidden peer" onchange="this.form.submit()" {{ request('category') == $cat->categoryId ? 'checked' : '' }}>
                                <div class="px-2 py-3 border border-transparent bg-[#053d30] rounded-xl text-[12px] font-bold text-green-50 text-center peer-checked:border-white peer-checked:text-[#064e3b] peer-checked:bg-white transition-all flex flex-col items-center justify-center gap-2 h-full hover:bg-white/10">
                                    @if(stripos($cat->categoryName, 'respiratory') !== false)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    @elseif(stripos($cat->categoryName, 'digestive') !== false)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.003 9.003 0 008.34-5.678c.495-1.383.136-2.73-.707-3.613l-1.071-1.072C17.72 9.8 17.2 8.4 17.2 7a5 5 0 00-10 0c0 1.4-.52 2.8-1.362 3.637l-1.071 1.072c-.843.883-1.202 2.23-.707 3.613A9.003 9.003 0 0012 21z"/></svg>
                                    @elseif(stripos($cat->categoryName, 'immune') !== false)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    @elseif(stripos($cat->categoryName, 'skin') !== false)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @elseif(stripos($cat->categoryName, 'pain') !== false || stripos($cat->categoryName, 'inflammation') !== false)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    @elseif(stripos($cat->categoryName, 'heart') !== false)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    @elseif(stripos($cat->categoryName, 'women') !== false || stripos($cat->categoryName, 'menstrual') !== false)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    @endif
                                    {{ str_replace(' health', '', str_replace(' system', '', $cat->categoryName)) }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Symptoms Filter -->
                    <div class="mb-8 flex-grow">
                        <h3 class="font-bold text-[15px] text-white mb-1">2. Select Symptoms <span class="text-green-200 font-normal text-[13px]">(Optional)</span></h3>
                        <p class="text-[13px] text-green-100 mb-4">Choose one or more symptoms you are experiencing.</p>
                        
                        <div class="relative mb-5">
                            <input type="text" id="symptomSearch" placeholder="Search symptoms..." class="w-full text-sm bg-[#053d30] border border-[#053d30] rounded-xl pl-10 py-2.5 text-white placeholder-green-200 focus:ring-white focus:border-white shadow-inner">
                            <svg class="w-5 h-5 text-green-200 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>

                        <div class="space-y-1.5 max-h-[360px] overflow-y-auto pr-3 scrollbar-style-dark" id="symptomsList">
                            @php
                                // Filter symptoms if a category is selected and we only want symptoms from that category
                                $displayedSymptoms = collect();
                                if(request()->filled('category')) {
                                    $displayedSymptoms = \App\Models\Symptom::where('categoryId', request('category'))->get();
                                } else {
                                    $displayedSymptoms = \App\Models\Symptom::all();
                                }
                            @endphp
                            @foreach($displayedSymptoms as $sym)
                            <label class="flex items-center justify-between p-2 hover:bg-[#053d30] rounded-lg cursor-pointer symptom-item group transition-colors" data-name="{{ strtolower($sym->symptomName) }}">
                                <div class="flex items-center gap-3">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="symptoms[]" value="{{ $sym->symptomId }}" class="peer w-4 h-4 text-white bg-[#064e3b] rounded border-green-200 focus:ring-white focus:ring-offset-0 focus:ring-offset-[#064e3b]" {{ in_array($sym->symptomId, (array)$selectedSymptoms) ? 'checked' : '' }}>
                                    </div>
                                    <span class="text-[13px] text-green-50 font-medium peer-checked:font-bold peer-checked:text-white group-hover:text-white transition-colors">{{ $sym->symptomName }}</span>
                                </div>
                                <div class="w-4 h-4 rounded-full border border-green-200/50 flex items-center justify-center text-green-200/50 group-hover:text-white group-hover:border-white transition-colors shrink-0">
                                    <span class="text-[10px] italic font-serif">i</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3 pt-6 border-t border-white/10">
                        <button type="button" onclick="clearAllSymptoms()" class="flex-[1] px-4 py-3 border border-white/20 text-green-50 rounded-xl text-sm font-bold hover:bg-white/10 flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Clear
                        </button>
                        <button type="submit" class="flex-[1.5] px-4 py-3 bg-white text-[#064e3b] rounded-xl text-sm font-bold hover:bg-green-50 flex items-center justify-center gap-2 shadow-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Apply
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-full lg:w-2/3 xl:flex-grow flex flex-col gap-6">
                    
                    @if(!empty($selectedSymptoms))
                    
                    @if($detectedCategory)
                    <!-- Detected Health Category -->
                    <div class="bg-[#f8fdf9] border border-[#d1f4db] rounded-[20px] p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-[#eaf5eb] rounded-full flex items-center justify-center shrink-0 border border-[#d1f4db]">
                                @if(stripos($detectedCategory->categoryName, 'respiratory') !== false)
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                @elseif(stripos($detectedCategory->categoryName, 'digestive') !== false)
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.003 9.003 0 008.34-5.678c.495-1.383.136-2.73-.707-3.613l-1.071-1.072C17.72 9.8 17.2 8.4 17.2 7a5 5 0 00-10 0c0 1.4-.52 2.8-1.362 3.637l-1.071 1.072c-.843.883-1.202 2.23-.707 3.613A9.003 9.003 0 0012 21z"/></svg>
                                @elseif(stripos($detectedCategory->categoryName, 'immune') !== false)
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @elseif(stripos($detectedCategory->categoryName, 'skin') !== false)
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif(stripos($detectedCategory->categoryName, 'pain') !== false || stripos($detectedCategory->categoryName, 'inflammation') !== false)
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                @elseif(stripos($detectedCategory->categoryName, 'heart') !== false)
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                @elseif(stripos($detectedCategory->categoryName, 'women') !== false || stripos($detectedCategory->categoryName, 'menstrual') !== false)
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                @else
                                    <svg class="w-8 h-8 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-[13px] font-bold text-gray-600 mb-0.5">Detected Health Category</h3>
                                <h2 class="text-xl md:text-[22px] font-bold text-[#064e3b] mb-1.5">{{ $detectedCategory->categoryName }}</h2>
                                <p class="text-[13px] md:text-[14px] text-gray-500">This category is automatically detected based on your selected symptoms using ontology relationships.</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-xl px-5 py-2.5 text-center shadow-sm shrink-0 self-stretch md:self-auto flex flex-col justify-center">
                            <p class="text-[11px] font-bold text-gray-800 mb-1.5 uppercase tracking-wide">Confidence Level</p>
                            <div class="flex items-center justify-center gap-1.5 text-[#10b981] font-bold text-sm bg-[#ecfdf5] px-3 py-1.5 rounded-md">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                High
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Selected Filters -->
                    <div class="bg-white border border-gray-200 rounded-[20px] p-6 shadow-sm">
                        <div class="flex items-center gap-2 text-[#064e3b] font-bold text-[17px] mb-5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Your Selections
                        </div>
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                            <div>
                                <p class="text-[13px] text-gray-500 mb-3 font-medium">Symptoms ({{ count($selectedSymptoms) }})</p>
                                <div class="flex flex-wrap gap-2.5">
                                    @php
                                        $selectedSymptomModels = \App\Models\Symptom::whereIn('symptomId', $selectedSymptoms)->get();
                                    @endphp
                                    @foreach($selectedSymptomModels as $sym)
                                        <div class="bg-[#f2fbf5] border border-[#d1f4db] text-[#064e3b] text-[13px] font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-2">
                                            {{ $sym->symptomName }}
                                            <button type="button" onclick="removeSymptom('{{ $sym->symptomId }}')" class="text-green-600 hover:text-red-500 transition-colors ml-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" onclick="document.getElementById('symptomSearch').focus()" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-lg text-sm font-bold hover:border-[#064e3b] hover:text-[#064e3b] flex items-center gap-2 transition-all shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit Selections
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Recommendations -->
                    <div class="mt-2">
                        <div class="mb-5">
                            <h2 class="text-xl font-bold text-[#064e3b] flex items-center gap-2 mb-1">
                                <svg class="w-6 h-6 text-[#10b981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                Explore Herbs
                            </h2>
                            <p class="text-[13px] text-gray-500 font-medium">Top herbs recommended for your selected symptoms</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($herbs as $index => $herb)
                            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-xl transition-all hover:-translate-y-1 relative group">
                                @php
                                    $relevance = (int) data_get($herb, 'relevance', 0);
                                    $relevanceClass = 'w-0';
                                    if ($relevance >= 90) {
                                        $relevanceClass = 'w-full';
                                    } elseif ($relevance >= 75) {
                                        $relevanceClass = 'w-4/5';
                                    } elseif ($relevance >= 50) {
                                        $relevanceClass = 'w-3/4';
                                    } elseif ($relevance >= 25) {
                                        $relevanceClass = 'w-1/2';
                                    } elseif ($relevance > 0) {
                                        $relevanceClass = 'w-1/4';
                                    }
                                @endphp
                                <!-- Image -->
                                <div class="h-44 overflow-hidden relative shrink-0">
                                    <img src="{{ $herb->image ?? 'https://images.unsplash.com/photo-1596591606975-97ee5cef3a1e?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $herb->herbName }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @if($index === 0 && (!empty($selectedSymptoms) || request()->filled('category')))
                                        <div class="absolute top-3 left-3 bg-[#064e3b] text-white text-[11px] font-bold px-2.5 py-1 rounded-lg flex items-center gap-1 shadow-md">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            Top Match
                                        </div>
                                    @endif
                                    @if($relevance > 0)
                                        <div class="absolute top-3 right-3 bg-[#10b981] text-white text-[11px] font-bold px-2.5 py-1 rounded-lg flex items-center gap-1 shadow-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/></svg>
                                            {{ $relevance }}% Match
                                        </div>
                                    @endif
                                </div>

                                <!-- Card Body -->
                                <div class="flex flex-col flex-grow">

                                    <!-- ── Herb Header ── -->
                                    <div class="px-5 pt-4 pb-3 border-b border-gray-100">
                                        <!-- Herb Name (single line, truncated if too long) -->
                                        <h3 class="text-[17px] font-extrabold text-[#064e3b] truncate leading-tight mb-1" title="{{ $herb->herbName }}">{{ $herb->herbName }}</h3>
                                        <!-- Scientific Name + Category in one row -->
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="text-[11px] text-gray-400 italic truncate flex-1">{{ $herb->scientificName ?? '—' }}</p>
                                            @if($herb->category)
                                                <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 bg-[#e8f5e9] text-[#166534] rounded-full border border-[#c8e6c9] whitespace-nowrap">{{ $herb->category->categoryName }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- ── Why Recommended ── -->
                                    <div class="px-5 py-3 border-b border-gray-100 flex-grow">
                                        <div class="flex items-center gap-1.5 mb-1.5">
                                            <svg class="w-3 h-3 text-yellow-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span class="text-[11px] font-bold text-yellow-700 uppercase tracking-wide">Why Recommended</span>
                                        </div>
                                        <p class="text-[12px] text-gray-600 leading-relaxed">
                                            {{ ucfirst(lcfirst($herb->benefits ?? 'Helps relieve symptoms and improve overall health based on traditional herbal knowledge.')) }}
                                        </p>
                                    </div>

                                    <!-- ── Match Score (if any) ── -->
                                    @if($relevance > 0)
                                    <div class="px-5 py-2.5 border-b border-gray-100 flex items-center justify-between gap-3">
                                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Match Score</span>
                                        <div class="flex items-center gap-2 flex-1 justify-end">
                                            <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-[#10b981] rounded-full {{ $relevanceClass }}"></div>
                                            </div>
                                            <span class="text-[13px] font-extrabold text-[#064e3b] min-w-[36px] text-right">{{ $relevance }}%</span>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- ── View Button ── -->
                                    <div class="px-5 py-4">
                                        <a href="{{ route('herb.show', $herb->herbId) }}" class="w-full py-2.5 bg-[#064e3b] text-white text-center text-[13px] font-bold rounded-xl hover:bg-[#053d30] shadow-sm transition-colors flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-100">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                <p class="text-gray-500 font-medium">No recommendations found. Try adjusting your selections.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Warning Alert -->
                    <div class="mt-8 bg-[#fffbeb] border border-[#fef3c7] rounded-xl p-5 flex items-start gap-4 shadow-sm">
                        <div class="p-2 bg-amber-100 rounded-full shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <p class="text-[13px] text-amber-800 leading-relaxed"><span class="font-bold">Note:</span> This recommendation is for informational purposes only and not a substitute for professional medical advice.</p>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <style>
        .scrollbar-style::-webkit-scrollbar {
            width: 5px;
        }
        .scrollbar-style::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.03);
            border-radius: 10px;
        }
        .scrollbar-style::-webkit-scrollbar-thumb {
            background: rgba(6, 78, 59, 0.2);
            border-radius: 10px;
        }
        .scrollbar-style-dark::-webkit-scrollbar {
            width: 5px;
        }
        .scrollbar-style-dark::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        .scrollbar-style-dark::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .scrollbar-style-dark::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const symptomSearch = document.getElementById('symptomSearch');

            if (symptomSearch) {
                symptomSearch.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase().trim();
                    const allItems = document.querySelectorAll('.symptom-item');

                    allItems.forEach(item => {
                        const name = item.dataset.name;
                        if (query === '' || name.includes(query)) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            }

            window.removeSymptom = function(symptomId) {
                const checkbox = document.querySelector(`input[name="symptoms[]"][value="${symptomId}"]`);
                if (checkbox) {
                    checkbox.checked = false;
                    document.getElementById('filterForm').submit();
                }
            };

            window.clearAllSymptoms = function() {
                const symptomCheckboxes = document.querySelectorAll('input[name="symptoms[]"]');
                symptomCheckboxes.forEach(cb => cb.checked = false);
                const categoryRadios = document.querySelectorAll('input[name="category"]');
                categoryRadios.forEach(radio => {
                    if (radio.value === "") {
                        radio.checked = true;
                    } else {
                        radio.checked = false;
                    }
                });
                document.getElementById('filterForm').submit();
            };
        });
    </script>

    <!-- How It Works Modal -->
    <div id="howItWorksModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center px-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('howItWorksModal').classList.add('hidden')"></div>
        <!-- Modal Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-[520px] w-full z-10 overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="bg-[#064e3b] px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h2 class="text-lg font-bold">How it works</h2>
                </div>
                <button type="button" onclick="document.getElementById('howItWorksModal').classList.add('hidden')" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-8 pb-10 space-y-8">
                <!-- Step 1 -->
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#dcfce7] text-[#064e3b] font-bold text-[15px] shrink-0">1</div>
                    <div>
                        <h3 class="text-[17px] font-bold text-[#1a1a1a] mb-1.5">Select a Category <span class="text-gray-400 font-normal text-[15px]">(Optional)</span></h3>
                        <p class="text-[15px] text-gray-500 leading-relaxed">Narrow down the list of symptoms by picking a specific health system, like Respiratory or Digestive health.</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#dcfce7] text-[#064e3b] font-bold text-[15px] shrink-0">2</div>
                    <div>
                        <h3 class="text-[17px] font-bold text-[#1a1a1a] mb-1.5">Choose Your Symptoms</h3>
                        <p class="text-[15px] text-gray-500 leading-relaxed">Search for and select the specific symptoms you are experiencing. You can select multiple symptoms at once.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#064e3b] text-white font-bold text-[15px] shrink-0">3</div>
                    <div>
                        <h3 class="text-[17px] font-bold text-[#064e3b] mb-1.5">Get Recommendations</h3>
                        <p class="text-[15px] text-gray-500 leading-relaxed">The system will match your selected symptoms to the most relevant herbal remedies instantly.</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 pb-8 flex justify-center">
                <button type="button" onclick="document.getElementById('howItWorksModal').classList.add('hidden')" class="px-8 py-3 bg-[#f3f6f4] hover:bg-[#e4e7e5] text-[#1a1a1a] text-[15px] font-bold rounded-xl transition-colors">
                    Got it, thanks!
                </button>
            </div>
        </div>
    </div>

</x-app-layout>
