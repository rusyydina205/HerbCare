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
