<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('practitioner.dashboard') }}" class="p-4 bg-white/10 text-white rounded-2xl hover:bg-white/20 transition-all border border-white/20 shadow-sm" title="Back to Dashboard">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-1">Account Management</p>
                <h2 class="font-serif font-bold text-4xl text-white leading-tight">My Profile</h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="mb-10 bg-green-50 border border-green-100 text-[#064e3b] px-8 py-5 rounded-[2rem] shadow-sm flex items-center gap-4 animate-in fade-in slide-in-from-top-4">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-3xl md:rounded-[3.5rem] shadow-2xl shadow-green-900/[0.03] border border-gray-100 overflow-hidden">
            <div class="p-6 md:p-16">
                <div class="flex flex-col md:flex-row gap-16 items-start">
                    
                    {{-- Profile Card Visual --}}
                    <div class="w-full md:w-1/3 space-y-8">
                        <div class="relative group">
                            <div class="w-48 h-48 mx-auto rounded-[3rem] overflow-hidden border-4 border-gray-50 shadow-2xl transition-transform duration-500 relative bg-white">
                                @php
                                    $avatar = $practitioner->profile_photo 
                                        ? asset('storage/profile_photos/' . $practitioner->profile_photo) 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($practitioner->name) . '&color=064e3b&background=e0efdb&size=512';
                                 @endphp
                                <img src="{{ $avatar }}" class="w-full h-full object-cover" alt="Profile Photo" id="profile_preview">
                            </div>
                            <label for="profile_photo" class="absolute bottom-2 right-1/2 translate-x-16 bg-white w-12 h-12 rounded-full border-2 border-gray-50 shadow-lg flex items-center justify-center cursor-pointer hover:scale-110 transition-transform text-[#064e3b] z-10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </label>
                            <!-- NOTE: The form wrapper must wrap the entire row since we are using flex, but the input is placed here -->
                        </div>

                        <div class="text-center space-y-2 pt-4">
                            <h3 class="text-2xl font-serif font-bold text-[#0f2818]">{{ $practitioner->name }}</h3>
                            <p class="text-sm text-gray-400 font-medium italic">{{ $practitioner->email }}</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-[2rem] p-8 border border-gray-100">
                            <p class="text-[10px] font-black text-[#064e3b]/40 uppercase tracking-widest mb-4">Clinic Stats</p>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-500">Member Since</span>
                                    <span class="text-xs font-black text-[#0f2818]">{{ $practitioner->created_at->format('M Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-500">Security Status</span>
                                    <span class="text-xs font-black text-green-600">Verified</span>
                                </div>
                            </div>

                            <div class="mt-6 border border-red-200 bg-red-50 rounded-2xl p-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[11px] font-black text-red-700 uppercase tracking-[0.2em]">Danger Zone</p>
                                        <p class="text-sm text-red-700/80 mt-1">Permanently delete your practitioner account and all associated access.</p>
                                        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account?')" class="mt-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2.5 bg-red-600 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-red-700 transition-all shadow-sm">
                                                Delete Account
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Form --}}
                    <div class="w-full md:w-2/3">
                        <form action="{{ route('practitioner.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                            @csrf
                            
                            <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">

                            <div class="grid grid-cols-1 gap-8">
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block ml-1">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $practitioner->name) }}" readonly
                                           class="w-full px-8 py-5 bg-[#f5fbf5] border border-[#dcefe0] rounded-2xl font-bold text-gray-500 cursor-not-allowed">
                                    <p class="text-[10px] text-gray-400 mt-1.5 px-1 font-medium">To update your name, please contact the clinic administrator.</p>
                                </div>

                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block ml-1">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $practitioner->email) }}" required
                                           class="w-full px-8 py-5 bg-[#f5fbf5] border border-[#dcefe0] rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818]">
                                    @error('email') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block ml-1">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $practitioner->phone) }}" pattern="[0-9]+" title="Only digits are allowed" placeholder="1234567890"
                                           class="w-full px-8 py-5 bg-[#f5fbf5] border border-[#dcefe0] rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818]">
                                    @error('phone') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div class="pt-6 border-t border-gray-50">
                                    <p class="text-[10px] font-black text-[#064e3b]/30 uppercase tracking-[0.2em] mb-6">Security Update (Optional)</p>
                                    
                                    <div class="space-y-6">
                                        <div>
                                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block ml-1">New Password</label>
                                            <input type="password" name="password" 
                                                   class="w-full px-8 py-5 bg-[#f5fbf5] border border-[#dcefe0] rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818]">
                                            @error('password') <p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                                        </div>

                                        <div>
                                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 block ml-1">Confirm New Password</label>
                                            <input type="password" name="password_confirmation" 
                                                   class="w-full px-8 py-5 bg-[#f5fbf5] border border-[#dcefe0] rounded-2xl focus:bg-white focus:border-[#064e3b] focus:ring-[#064e3b] transition-all font-bold text-[#0f2818]">
                                            <p class="text-[11px] text-gray-500 mt-2 font-medium">Leave blank to keep current password.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-10 flex justify-end">
                                <button type="submit" class="px-12 py-5 bg-[#064e3b] text-white text-[11px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#08634a] transition-all shadow-2xl hover:-translate-y-1 active:scale-95">
                                    Save Profile Changes
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
