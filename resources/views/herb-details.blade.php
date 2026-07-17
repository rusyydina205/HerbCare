<x-app-layout>
    <div class="py-8 bg-[#fafaf9] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Navigation & Breadcrumbs -->
            <div class="flex items-center gap-6 mb-8 bg-gray-100 p-3 pr-8 rounded-[2rem] shadow-sm border border-gray-200/60 w-fit group">
                <a href="{{ $backRoute ?? route('dashboard') }}" class="p-3 bg-[#0f2818] text-white border border-[#0f2818]/20 rounded-2xl hover:bg-[#1a4d2e] shadow-sm transition-all hover:shadow-md active:scale-95">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <nav class="flex text-sm text-[#0f2818] font-medium" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-[10px] sm:text-xs font-extrabold uppercase tracking-[0.15em]">
                        <li><a href="{{ $backRoute ?? route('dashboard') }}" class="text-[#0f2818] hover:text-[#1a4d2e] transition-colors">Back to Herb Library</a></li>
                        <li><span class="mx-3 opacity-30 text-xs">/</span></li>
                        
                    </ol>
                </nav>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Hero Image -->
                    <div class="relative w-full h-[400px] rounded-[2rem] overflow-hidden shadow-sm">
                        <img src="{{ asset($herb->image) }}" alt="{{ $herb->herbName }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-4 right-4">
                            <span class="bg-white/90 backdrop-blur-md text-xs font-bold px-4 py-2 rounded-full text-gray-700 shadow-sm inline-block">
                                Taxonomy: {{ $herb->scientificName }}
                            </span>
                        </div>
                    </div>

                    <!-- Title & Tags -->
                    <div>
                        <div class="flex flex-col md:flex-row justify-between items-start gap-6 border-b border-gray-100 pb-8">
                            <div>
                                <h1 class="text-5xl font-serif font-bold text-[#0f2818] mb-2">{{ $herb->herbName }}</h1>
                                <p class="text-xl italic text-[#166534]/60 font-serif font-medium">{{ $herb->scientificName }}</p>
                            </div>
                            <div class="flex gap-4 w-full md:w-auto">
                                    @auth
                                    @if(auth()->user() instanceof \App\Models\Patient)
                                        @php
                                            $isFavourited = \App\Models\Recommendation::where('patientId', auth()->user()->patientId)
                                                ->where('herbsId', $herb->herbId)
                                                ->whereNull('symptomId')
                                                ->exists();
                                        @endphp
                                        <button id="fav-btn"
                                            data-url="{{ route('herb.favourite', $herb->herbId) }}"
                                            data-csrf="{{ csrf_token() }}"
                                            data-favourited="{{ $isFavourited ? 'true' : 'false' }}"
                                            data-herb-id="{{ $herb->herbId }}"
                                            data-herb-name="{{ $herb->herbName }}"
                                            data-herb-url="{{ route('herb.show', $herb->herbId) }}"
                                            title="{{ $isFavourited ? 'Already in your favorites' : 'Add to favorites' }}"
                                            class="p-4 rounded-2xl shadow-sm border transition-all group active:scale-95
                                                   {{ $isFavourited ? 'bg-red-50 text-red-500 border-red-200 cursor-default' : 'bg-white text-[#064e3b] border-gray-100 hover:bg-red-50 hover:text-red-500 hover:border-red-100 hover:shadow-md' }}">
                                            <svg id="fav-icon" class="w-6 h-6" viewBox="0 0 24 24"
                                                 fill="{{ $isFavourited ? 'currentColor' : 'none' }}"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-3 mt-6">
                            <span class="px-5 py-2 bg-green-50 text-[#064e3b] text-xs font-extrabold rounded-full uppercase tracking-wider border border-green-100">{{ $herb->category->categoryName }}</span>
                            @if(isset($herb->relevance))
                                <span class="px-5 py-2 bg-blue-50 text-blue-800 text-xs font-extrabold rounded-full uppercase tracking-wider border border-blue-100">{{ $herb->relevance }}% Match Relevance</span>
                            @endif
                        </div>
                    </div>

                    <!-- Herb Benefits -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <svg class="w-6 h-6 text-[#2f4f2f]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                            </div>
                            <h2 class="text-2xl font-serif font-bold text-gray-900">Herb Benefits</h2>
                        </div>
                        
                        <ul class="space-y-6">
                            @php 
                                $benefits = array_filter(explode('. ', $herb->benefits), 'trim'); 
                                if(count($benefits) < 3) {
                                    if(!in_array("Enhances holistic wellness according to traditional meridian theory", $benefits)) $benefits[] = "Enhances holistic wellness according to traditional meridian theory.";
                                    if(!in_array("Offers natural antioxidant properties to protect cellular health", $benefits)) $benefits[] = "Offers natural antioxidant properties to protect cellular health.";
                                    if(!in_array("Supports immune function and natural resistance to environmental stressors", $benefits)) $benefits[] = "Supports immune function and natural resistance to environmental stressors.";
                                }
                            @endphp
                            @foreach(array_slice($benefits, 0, max(3, count($benefits))) as $benefit)
                                <li class="flex items-start gap-4 text-gray-600 leading-relaxed font-medium">
                                    <span class="mt-2.5 w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>
                                    <span>{{ trim($benefit) }}{{ str_ends_with(trim($benefit), '.') ? '' : '.' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Preparation Methods -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="p-3 bg-[#eef0ee] rounded-xl text-[#2f4f2f]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.054.585l-1.835 1.835a1 1 0 01-1.414-1.414l1.835-1.835a4 4 0 012.108-1.17l2.387-.477a4 4 0 002.574-.344l.318-.158a4 4 0 012.574-.344l2.387.477a4 4 0 012.108 1.17l1.835 1.835a1 1 0 01-1.414 1.414l-1.835-1.835z"></path></svg>
                            </div>
                            <h2 class="text-xl font-serif font-bold text-gray-900">Preparation Methods</h2>
                        </div>
                        
                        @php
                            $prepSteps = array_filter(array_map('trim', preg_split('/\s*\.\s*/', trim($herb->preparation ?? ''))), fn($item) => $item !== '');
                            $defaultPrepMethods = [
                                'Simmer the herb in water for 20-30 minutes and drink the decoction warm.',
                                'Soak the herb in warm water, then strain and sip slowly throughout the day.',
                                'Grind the herb into a fine powder and take it with honey or warm liquid.',
                            ];

                            if (empty($prepSteps)) {
                                $prepSteps = $defaultPrepMethods;
                            } else {
                                foreach ($defaultPrepMethods as $method) {
                                    if (count($prepSteps) >= 3) {
                                        break;
                                    }

                                    if (!in_array($method, $prepSteps, true)) {
                                        $prepSteps[] = $method;
                                    }
                                }
                            }
                        @endphp
                        
                        <div class="space-y-4">
                            @foreach(array_slice($prepSteps, 0, 3) as $index => $step)
                                @php
                                    $parts = explode(':', $step, 2);
                                    $title = count($parts) > 1 ? trim($parts[0]) : "Step " . ($index + 1);
                                    $desc = count($parts) > 1 ? trim($parts[1]) : trim($step);
                                @endphp
                                <div class="bg-[#f9fafb] rounded-[1rem] p-5 shadow-sm border-l-4 border-gray-600 relative">
                                    <h3 class="font-bold text-gray-900 text-sm mb-1.5">{{ $title }}</h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}{{ str_ends_with($desc, '.') ? '' : '.' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Safety & Precautions -->
                    <div class="bg-[#fff1f2] rounded-[2rem] p-8 shadow-sm border border-red-100">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="text-[#9f1239]">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-serif font-bold text-[#881337]">Safety & Precautions</h2>
                        </div>
                        
                        @php
                            $safetyItems = array_filter(explode('. ', $herb->safety), 'trim');
                            if(count($safetyItems) < 2) {
                                $safetyItems = [
                                    trim($herb->safety) ?: "Avoid excessive consumption if you have a high fever or 'excess heat' constitution in TCM terms.",
                                    "Consult a doctor if taking blood-thinning medications, as certain herbs may have a mild anticoagulant effect."
                                ];
                            }
                        @endphp

                        <div class="space-y-5">
                            @foreach(array_slice($safetyItems, 0, 2) as $safety)
                                <p class="text-[#b91c1c] text-sm leading-relaxed font-semibold">
                                    {{ trim($safety) }}{{ str_ends_with(trim($safety), '.') ? '' : '.' }}
                                </p>
                            @endforeach
                        </div>
                    </div>

                    <!-- Saved Favorites Sidebar -->
                    <div class="bg-[#064e3b] rounded-[2rem] p-8 shadow-xl relative overflow-hidden flex flex-col justify-between">
                        <p class="text-green-200/80 text-xs font-bold uppercase tracking-widest mb-1.5 relative z-10">Your Favorites</p>
                        <h3 class="text-2xl font-serif font-bold text-white mb-6 relative z-10">Saved Favorites</h3>
                        
                        <div id="popular-list" class="space-y-3 relative z-10 min-h-[50px]">
                            @forelse($popularHerbs as $popular)
                                <a href="{{ route('herb.show', $popular->herbId) }}" data-herb-id="{{ $popular->herbId }}" class="popular-item block bg-white/10 hover:bg-white/20 transition-all rounded-xl p-4 border border-white/10 backdrop-blur-sm group/pop">
                                    <div class="flex items-center justify-between">
                                        <span class="text-white font-bold text-sm">
                                            {{ $popular->herbName }}
                                            <span class="ml-1 text-red-400">❤️</span>
                                        </span>
                                        <svg class="w-4 h-4 text-white/40 group-hover/pop:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </a>
                            @empty
                                <div id="empty-fav-msg" class="text-green-200/50 text-[11px] italic p-4 border border-dashed border-white/10 rounded-xl text-center">
                                    Your favorited herbs will appear here.
                                </div>
                            @endforelse
                        </div>
                        <a href="https://www.kienfattmed.com/collections/tcm-herbs" target="_blank" class="w-full inline-flex items-center justify-center bg-[#b7950b] text-white font-extrabold py-4 mt-6 rounded-xl hover:bg-[#9a7d0a] transition-all gap-2 text-sm relative z-10 shadow-lg active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Shop TCM Store
                        </a>
                    </div>

                </div>
            </div>

            <!-- Footer Disclaimer -->
            <div class="mt-16 mb-8 text-center text-gray-400 text-xs max-w-2xl mx-auto leading-relaxed border-t border-gray-200 pt-8">
                Disclaimer: This information is for educational purposes only and is not intended to substitute for professional medical advice, diagnosis, or treatment. Always seek the advice of your physician or other qualified health provider.
                <div class="mt-4 flex justify-center space-x-6">
                    <a href="#" class="hover:text-gray-600 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-gray-600 transition-colors">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast --}}
    <div id="fav-toast" class="hidden fixed bottom-8 right-8 z-50 flex items-center gap-3 bg-[#064e3b] text-white px-6 py-4 rounded-2xl shadow-2xl text-sm font-bold transition-all">
        <span id="fav-toast-icon">❤️</span>
        <span id="fav-toast-msg">Added to favourites!</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('fav-btn');
            if (!btn) return;

            // Set initial title
            if (btn.dataset.favourited === 'true') {
                btn.title = 'Remove from favorites';
            }

            btn.addEventListener('click', async () => {
                const url      = btn.dataset.url;
                const csrf     = btn.dataset.csrf;
                const herbId   = btn.dataset.herbId;
                const herbName = btn.dataset.herbName;
                const herbUrl  = btn.dataset.herbUrl;
                const icon     = document.getElementById('fav-icon');
                const list     = document.getElementById('popular-list');

                btn.disabled = true; // Temporary disable to prevent double clicks

                try {
                    const res  = await fetch(url, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                    });
                    const data = await res.json();

                    if (data.favourited) {
                        // Show Toast
                        const toast = document.getElementById('fav-toast');
                        const toastMsg = document.getElementById('fav-toast-msg');
                        if (toast) {
                            if (toastMsg) toastMsg.innerText = 'Added to favourites!';
                            toast.classList.remove('hidden');
                            setTimeout(() => toast.classList.add('hidden'), 3000);
                        }

                        // Fill heart
                        if (icon) icon.setAttribute('fill', 'currentColor');
                        btn.classList.add('bg-red-50', 'text-red-500', 'border-red-200');
                        btn.classList.remove('bg-white', 'text-[#064e3b]', 'border-gray-100', 'hover:shadow-md');
                        
                        btn.dataset.favourited = 'true';
                        btn.title = 'Remove from favorites';

                        // sidebar
                        if (list) {
                            const emptyMsg = document.getElementById('empty-fav-msg');
                            if (emptyMsg) emptyMsg.remove();

                            if (!list.querySelector(`[data-herb-id="${herbId}"]`)) {
                                const card = document.createElement('a');
                                card.href = herbUrl;
                                card.dataset.herbId = herbId;
                                card.className = 'popular-item block bg-white/10 hover:bg-white/20 transition-all rounded-xl p-4 border border-white/10 backdrop-blur-sm group/pop';
                                card.innerHTML = `<div class="flex items-center justify-between">
                                    <span class="text-white font-bold text-sm">
                                        ${herbName}
                                        <span class="ml-1 text-red-400">❤️</span>
                                    </span>
                                    <svg class="w-4 h-4 text-white/40 group-hover/pop:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>`;
                                list.prepend(card);
                            }
                        }
                    } else {
                        // REMOVE FAVOURITE
                        const toast = document.getElementById('fav-toast');
                        const toastMsg = document.getElementById('fav-toast-msg');
                        if (toast) {
                            if (toastMsg) toastMsg.innerText = 'Removed from favourites';
                            toast.classList.remove('hidden');
                            setTimeout(() => toast.classList.add('hidden'), 3000);
                        }

                        // Unfill heart
                        if (icon) icon.setAttribute('fill', 'none');
                        btn.classList.remove('bg-red-50', 'text-red-500', 'border-red-200');
                        btn.classList.add('bg-white', 'text-[#064e3b]', 'border-gray-100');
                        
                        btn.dataset.favourited = 'false';
                        btn.title = 'Add to favorites';

                        // Remove from sidebar
                        if (list) {
                            const item = list.querySelector(`[data-herb-id="${herbId}"]`);
                            if (item) item.remove();

                            if (list.children.length === 0) {
                                list.innerHTML = `<div id="empty-fav-msg" class="text-green-200/50 text-[11px] italic p-4 border border-dashed border-white/10 rounded-xl text-center">
                                    Your favorited herbs will appear here.
                                </div>`;
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error favouriting herb:', error);
                } finally {
                    btn.disabled = false;
                }
            });
        });
    </script>
</x-app-layout>
