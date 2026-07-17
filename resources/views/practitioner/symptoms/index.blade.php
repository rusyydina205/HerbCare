<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('practitioner.dashboard') }}" class="p-4 bg-white/10 text-white rounded-2xl hover:bg-white/20 transition-all border border-white/20 shadow-sm" title="Back to Dashboard">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-1">Welcome, Practitioner</p>
                    <h2 class="font-serif font-bold text-4xl text-white leading-tight">
                        Manage Symptoms
                    </h2>
                </div>
            </div>
            <div>
                <button onclick="document.getElementById('add-symptom-modal').classList.remove('hidden')" class="inline-flex items-center bg-white text-[#064e3b] font-bold py-4 px-8 rounded-2xl hover:bg-green-50 transition-all shadow-xl hover:-translate-y-0.5 active:scale-95 gap-3 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    New Symptom
                </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10">
        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="relative group w-full md:w-96">
                <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-gray-400 group-focus-within:text-[#064e3b]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <form action="{{ route('practitioner.symptoms.index') }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search symptom name or description..." 
                           class="w-full pl-12 pr-6 py-4 bg-white border-gray-100 rounded-2xl text-sm focus:border-[#064e3b] focus:ring-[#064e3b] transition-all shadow-sm">
                </form>
            </div>
            
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                Showing {{ $symptoms->count() }} of {{ $symptoms->total() }} recorded symptoms
            </p>
        </div>

        <!-- Symptoms Grid Table -->
        <div class="bg-white rounded-[3rem] shadow-xl shadow-green-900/[0.02] border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Symptom Context</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($symptoms as $symptom)
                        <tr class="hover:bg-green-50/20 transition-all group">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-[#064e3b] border border-green-100 shadow-sm group-hover:scale-105 transition-transform">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xl font-serif font-bold text-[#0f2818] mb-1">{{ $symptom->symptomName }}</p>
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="inline-flex items-center px-3 py-1 bg-green-50 text-[#064e3b] text-[9px] font-black rounded-full uppercase tracking-widest border border-green-100">
                                                {{ $symptom->category->categoryName ?? 'Uncategorized' }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-400 font-medium max-w-2xl line-clamp-2 leading-relaxed">
                                            {{ $symptom->description ?: 'No additional clinical notes provided.' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <button onclick="viewSymptom({{ json_encode($symptom) }})" class="p-3 bg-gray-50 text-gray-400 rounded-xl hover:bg-gray-200 transition-all" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button onclick="editSymptom({{ json_encode($symptom) }})" class="p-3 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit Symptom">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('practitioner.symptoms.destroy', $symptom->symptomId) }}" method="POST" onsubmit="return confirm('Delete this symptom?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-10 py-32 text-center text-gray-400 font-serif italic text-lg">No symptoms recorded in clinical database.</td></tr>
                    @endforelse
                </tbody>
            </table>
            
            @if ($symptoms->hasPages())
                <div class="px-10 py-8 border-t border-gray-100 bg-gray-50/30">
                    {{ $symptoms->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modals (Add/Edit) -->
    <div id="add-symptom-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-12 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
            
            <div class="inline-block w-full max-w-3xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-3xl rounded-[3rem] p-12 border border-gray-100">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-3xl font-serif font-bold text-[#0f2818]" id="modal-title">Add New Symptom</h3>
                    <button onclick="closeModal()" class="p-3 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="symptom-form" action="{{ route('practitioner.symptoms.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    
                    <div class="space-y-8">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-3 ml-1">Symptom Name</label>
                            <input type="text" name="symptomName" id="symptomName" required class="w-full px-8 py-5 bg-gray-50 border-gray-200 rounded-[1.5rem] focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818]" placeholder="e.g. Chronic Fatigue">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-3 ml-1">Health Category</label>
                            <select name="categoryId" id="categoryId" required class="w-full px-8 py-5 bg-gray-50 border-gray-200 rounded-[1.5rem] focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818] appearance-none cursor-pointer">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->categoryId }}">{{ $cat->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block mb-3 ml-1">Clinical Description</label>
                            <textarea name="description" id="description" rows="5" class="w-full px-8 py-6 bg-gray-50 border-gray-200 rounded-[2rem] focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all text-gray-600 leading-relaxed" placeholder="Detailed symptoms, observations, and cross-references..."></textarea>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-12">
                        <button type="button" onclick="closeModal()" class="flex-1 bg-gray-50 text-gray-500 font-bold py-5 rounded-[1.5rem] hover:bg-gray-100 transition-all border border-gray-100 uppercase tracking-widest text-xs">Discard</button>
                        <button type="submit" id="save-button" class="flex-1 bg-[#064e3b] text-white font-bold py-5 rounded-[1.5rem] hover:bg-[#043327] transition-all shadow-xl active:scale-95 uppercase tracking-widest text-xs">Save Symptom Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function viewSymptom(symptom) {
            document.getElementById('add-symptom-modal').classList.remove('hidden');
            document.getElementById('modal-title').innerText = "Symptom Profile";
            document.getElementById('symptomName').value = symptom.symptomName;
            document.getElementById('categoryId').value = symptom.categoryId;
            document.getElementById('description').value = symptom.description;
            document.getElementById('symptomName').disabled = true;
            document.getElementById('categoryId').disabled = true;
            document.getElementById('description').disabled = true;
            document.getElementById('save-button').classList.add('hidden');
        }

        function closeModal() {
            document.getElementById('add-symptom-modal').classList.add('hidden');
            document.getElementById('symptom-form').action = "{{ route('practitioner.symptoms.store') }}";
            document.getElementById('form-method').value = "POST";
            document.getElementById('modal-title').innerText = "Add New Symptom";
            document.getElementById('symptomName').value = "";
            document.getElementById('categoryId').value = "";
            document.getElementById('description').value = "";
            document.getElementById('symptomName').disabled = false;
            document.getElementById('categoryId').disabled = false;
            document.getElementById('description').disabled = false;
            document.getElementById('save-button').classList.remove('hidden');
        }

        function editSymptom(symptom) {
            document.getElementById('add-symptom-modal').classList.remove('hidden');
            document.getElementById('symptom-form').action = "/practitioner/symptoms/" + symptom.symptomId;
            document.getElementById('form-method').value = "PUT";
            document.getElementById('modal-title').innerText = "Modify Symptom";
            document.getElementById('symptomName').value = symptom.symptomName;
            document.getElementById('categoryId').value = symptom.categoryId;
            document.getElementById('description').value = symptom.description;
            document.getElementById('symptomName').disabled = false;
            document.getElementById('categoryId').disabled = false;
            document.getElementById('description').disabled = false;
            document.getElementById('save-button').classList.remove('hidden');
        }

        window.addEventListener('load', () => {
            const params = new URLSearchParams(window.location.search);
            if (params.get('action') === 'add') {
                document.getElementById('add-symptom-modal').classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
