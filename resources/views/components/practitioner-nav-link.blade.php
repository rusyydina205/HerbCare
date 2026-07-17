@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-4 px-5 py-4 rounded-2xl bg-white/10 text-white shadow-sm font-bold text-sm transition-all border border-white/20'
            : 'flex items-center gap-4 px-5 py-4 rounded-2xl text-green-200/60 hover:text-white hover:bg-white/5 transition-all font-bold text-sm border border-transparent';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
    </svg>
    {{ $slot }}
</a>
