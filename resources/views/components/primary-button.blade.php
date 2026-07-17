<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#166534] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#14532d] focus:bg-[#14532d] active:bg-[#064e3b] focus:outline-none focus:ring-2 focus:ring-[#166534] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md']) }}>
    {{ $slot }}
</button>
