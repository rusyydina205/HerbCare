<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 p-2 rounded-[3rem] relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] mb-2">Clinic Directory</p>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-white leading-tight">Patient Registry</h2>
            </div>
            
            <div class="relative z-10 w-full sm:w-auto">
                <form action="{{ route('practitioner.patients.index') }}" method="GET" class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-gray-400 group-focus-within:text-[#064e3b]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by name, email..." 
                           class="w-full sm:w-80 pl-11 pr-5 py-4 bg-white border-2 border-transparent rounded-2xl text-[#0f2818] text-xs font-bold focus:border-[#064e3b] focus:ring-0 transition-all shadow-lg placeholder-gray-400">
                </form>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="flex items-center gap-4">
            <a href="{{ route('practitioner.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-[#064e3b] rounded-full hover:bg-green-50 transition-colors border border-gray-200 shadow-sm text-xs font-black uppercase tracking-widest group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-green-900/[0.03] border border-gray-100 overflow-hidden transition-all duration-500">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Patient Details</th>
                            <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Contact Info</th>
                            <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-center">Consultations</th>
                            <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Registered On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($patients as $patient)
                            <tr class="hover:bg-[#f9fbf8] transition-colors duration-300 group">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="relative flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                            @if($patient->profile_photo)
                                                <img src="{{ asset('profile_photos/' . $patient->profile_photo) }}" 
                                                     class="w-14 h-14 rounded-2xl object-cover border-2 border-white shadow-md group-hover:shadow-green-900/10" alt="">
                                            @else
                                                <div class="w-14 h-14 bg-green-50 text-[#064e3b] rounded-2xl flex items-center justify-center text-lg font-black border-2 border-white shadow-md group-hover:shadow-green-900/10">
                                                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#0f2818] text-base group-hover:text-[#064e3b] transition-colors">{{ $patient->name }}</p>
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">ID: #{{ str_pad($patient->patientId, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <div class="space-y-2">
                                        <p class="text-sm text-gray-600 font-medium flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            {{ $patient->email }}
                                        </p>
                                        <p class="text-sm text-gray-600 font-medium flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $patient->phone ?? 'Not provided' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-center">
                                    <span class="inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-bold rounded-xl border border-blue-100 shadow-sm">
                                        {{ $patient->messages_count }} Messages
                                    </span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <p class="text-sm font-bold text-[#0f2818]">{{ $patient->created_at->format('M d, Y') }}</p>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">{{ $patient->created_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-10 py-32 text-center border-none">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mb-6 shadow-inner">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="text-gray-500 font-serif italic text-lg">No patients found matching your search.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-10 py-8 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-xs font-bold text-gray-500">
                    Showing <span class="text-[#064e3b]">{{ $patients->firstItem() ?? 0 }}</span> to <span class="text-[#064e3b]">{{ $patients->lastItem() ?? 0 }}</span> of <span class="text-[#064e3b]">{{ $patients->total() }}</span> patients
                </div>
                <div>
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
