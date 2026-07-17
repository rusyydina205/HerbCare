<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('practitioner.dashboard') }}" class="p-4 bg-white border border-gray-100 rounded-2xl text-gray-400 hover:text-[#064e3b] shadow-sm transition-all hover:shadow-md active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">{{ isset($herb->herbId) ? 'Refine Database Record' : 'Create New Clinical Entry' }}</p>
                <h2 class="font-serif font-bold text-4xl text-[#0f2818] leading-tight">
                    {{ isset($herb->herbId) ? 'Edit: ' . $herb->herbName : 'Add New Herb' }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-12 pb-20">
        <form action="{{ isset($herb->herbId) ? route('practitioner.herbs.update', $herb->herbId) : route('practitioner.herbs.store') }}" method="POST">
            @csrf
            @if(isset($herb->herbId))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Identifying Information -->
                <div class="lg:col-span-12">
                    <div class="bg-white rounded-[3rem] p-12 shadow-xl shadow-green-900/[0.02] border border-gray-100 space-y-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div>
                                <label class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-4 ml-1 block">Herb Common Name</label>
                                <input type="text" name="herbName" value="{{ old('herbName', $herb->herbName ?? '') }}" required 
                                       class="w-full bg-gray-50 border-gray-100 text-[#0f2818] text-lg rounded-2xl focus:ring-[#064e3b] focus:border-[#064e3b] block p-6 px-8 transition-all font-bold placeholder-gray-300" 
                                       placeholder="e.g. Goji Berry">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-4 ml-1 block">Scientific/Botanical Name</label>
                                <input type="text" name="scientificName" value="{{ old('scientificName', $herb->scientificName ?? '') }}" required 
                                       class="w-full bg-gray-50 border-gray-100 text-[#0f2818] text-lg rounded-2xl focus:ring-[#064e3b] focus:border-[#064e3b] block p-6 px-8 transition-all font-bold italic placeholder-gray-300" 
                                       placeholder="e.g. Lycium barbarum">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div>
                                <label class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-4 ml-1 block">TCM Classification Category</label>
                                <div class="relative">
                                    <select name="categoryId" required class="w-full bg-gray-50 border-gray-100 text-[#0f2818] text-sm rounded-2xl focus:ring-[#064e3b] focus:border-[#064e3b] block p-6 px-8 transition-all font-bold appearance-none">
                                        <option value="" disabled {{ !isset($herb->categoryId) ? 'selected' : '' }}>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->categoryId }}" {{ (old('categoryId', $herb->categoryId ?? '') == $category->categoryId) ? 'selected' : '' }}>
                                                {{ $category->categoryName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-4 ml-1 block">Reference Image URL</label>
                                <input type="text" name="image" value="{{ old('image', $herb->image ?? '') }}" 
                                       class="w-full bg-gray-50 border-gray-100 text-[#0f2818] text-sm rounded-2xl focus:ring-[#064e3b] focus:border-[#064e3b] block p-6 px-8 transition-all font-bold placeholder-gray-300" 
                                       placeholder="images/herbs/filename.jpg">
                            </div>
                        </div>

                        <div class="space-y-10">
                            <div>
                                <label class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-4 ml-1 block">Therapeutic Benefits & Indications</label>
                                <textarea name="benefits" rows="6" required 
                                          class="w-full bg-gray-50 border-gray-100 text-gray-600 text-sm rounded-[2rem] focus:ring-[#064e3b] focus:border-[#064e3b] block p-8 transition-all font-medium resize-none leading-relaxed" 
                                          placeholder="Primary healing properties, TCM organ associations, and clinical indications...">{{ old('benefits', $herb->benefits ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div>
                                    <label class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-4 ml-1 block">Traditional Preparation</label>
                                    <textarea name="preparation" rows="5" required 
                                              class="w-full bg-gray-50 border-gray-100 text-gray-600 text-xs rounded-[2rem] focus:ring-[#064e3b] focus:border-[#064e3b] block p-8 transition-all font-medium resize-none leading-relaxed" 
                                              placeholder="Decoction methods, dosage notes, and usage guidelines...">{{ old('preparation', $herb->preparation ?? '') }}</textarea>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-orange-600 uppercase tracking-[0.2em] mb-4 ml-1 block">Contraindications & Safety</label>
                                    <textarea name="safety" rows="5" required 
                                              class="w-full bg-orange-50/30 border-orange-100/50 text-gray-600 text-xs rounded-[2rem] focus:ring-orange-500 focus:border-orange-500 block p-8 transition-all font-medium resize-none leading-relaxed" 
                                              placeholder="Potential side effects, drug interactions, and warnings for pregnancy/specific conditions...">{{ old('safety', $herb->safety ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="space-y-6 pt-6">
                                <label class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.2em] mb-4 ml-1 block">Associated Symptoms & Clinical Indications</label>
                                <div class="bg-gray-50/50 border border-gray-100 rounded-[2.5rem] p-10 max-h-[500px] overflow-y-auto custom-scrollbar shadow-inner">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                        @foreach($allSymptoms as $categoryName => $symptoms)
                                            <div class="space-y-6">
                                                <h5 class="text-[10px] font-black text-[#064e3b] uppercase tracking-widest border-b border-green-100 pb-3">{{ $categoryName }}</h5>
                                                <div class="grid gap-4">
                                                    @php $herbSymptomIds = $herb->symptoms->pluck('symptomId')->toArray(); @endphp
                                                    @foreach($symptoms as $symptom)
                                                        <label class="flex items-center gap-4 group cursor-pointer">
                                                            <div class="relative flex items-center justify-center">
                                                                <input type="checkbox" name="symptoms[]" value="{{ $symptom->symptomId }}" 
                                                                       {{ in_array($symptom->symptomId, old('symptoms', $herbSymptomIds)) ? 'checked' : '' }}
                                                                       class="w-6 h-6 rounded-lg border-gray-200 text-[#064e3b] focus:ring-[#064e3b] transition-all cursor-pointer">
                                                            </div>
                                                            <span class="text-sm font-bold text-gray-500 group-hover:text-[#064e3b] transition-colors leading-tight">{{ $symptom->symptomName }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-10 flex items-center justify-between border-t border-gray-100">
                            <a href="{{ route('practitioner.dashboard') }}" class="text-xs font-black text-gray-400 uppercase tracking-widest hover:text-[#064e3b] transition-colors px-4 py-2">Discard Changes</a>
                            <button type="submit" class="bg-[#064e3b] text-white font-bold py-5 px-12 rounded-2xl hover:bg-[#043327] transition-all shadow-xl hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-xs">
                                {{ isset($herb->herbId) ? 'Update Database Record' : 'Commit New Entry' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="text-center">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">Clinical Precision Required for All Entries</p>
        </div>
    </div>
</x-app-layout>
