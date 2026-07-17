<section class="space-y-6">
    <div class="text-center py-6 text-black">
    <div class="w-16 h-16 bg-[#fff1f0] rounded-full flex items-center justify-center text-red-500 mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"></path></svg>
    </div>
    <h4 class="text-xl font-serif font-bold text-[#0f2818] mb-2">Delete Account</h4>
    <p class="text-sm text-gray-500 max-w-sm mx-auto mb-8 leading-relaxed">Once deleted, all your data will be <span class="text-red-600 font-bold">permanently removed</span> and this action <span class="text-red-600 font-bold">cannot be undone</span>.</p>
    
    <form method="post" action="{{ route('profile.destroy') }}" class="p-0 inline-block w-full max-w-sm">
        @csrf
        @method('delete')
        <button type="submit" onclick="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.');" class="w-full bg-white hover:bg-red-50 border-2 border-red-600 text-red-600 font-bold py-4 rounded-2xl flex items-center justify-center gap-3 transition-all active:scale-95 text-xs uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"></path></svg>
            {{ __('Delete My Account') }}
        </button>
    </form>
</div>
</section>
