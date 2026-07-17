@props(['title', 'value', 'label', 'icon', 'trend' => null, 'isAlert' => false, 'accent' => 'green'])

@php
    $wrapperBg = $accent === 'blue' ? 'bg-blue-50 border-blue-100' : ($accent === 'pink' ? 'bg-pink-50 border-pink-100' : ($accent === 'orange' ? 'bg-orange-50 border-orange-100' : ($isAlert ? 'bg-orange-50 border-orange-100' : 'bg-white border-gray-100')));
    $iconBg = $accent === 'blue' ? 'bg-blue-100' : ($accent === 'pink' ? 'bg-pink-100' : ($accent === 'orange' ? 'bg-orange-100' : ($isAlert ? 'bg-orange-100/50' : 'bg-green-50')));
    $iconText = $accent === 'blue' ? 'text-blue-600' : ($accent === 'pink' ? 'text-pink-600' : ($accent === 'orange' ? 'text-orange-600' : ($isAlert ? 'text-orange-600' : 'text-[#064e3b]')));
    $titleText = $accent === 'blue' ? 'text-blue-600/70' : ($accent === 'pink' ? 'text-pink-600/70' : ($accent === 'orange' ? 'text-orange-600/60' : ($isAlert ? 'text-orange-600/60' : 'text-gray-400')));
    $valueText = $accent === 'blue' ? 'text-blue-700' : ($accent === 'pink' ? 'text-pink-700' : ($accent === 'orange' ? 'text-orange-700' : ($isAlert ? 'text-orange-700' : 'text-[#0f2818]')));
    $labelText = $accent === 'blue' ? 'text-blue-600/80' : ($accent === 'pink' ? 'text-pink-600/80' : ($accent === 'orange' ? 'text-orange-600/80' : ($isAlert ? 'text-orange-600/80' : 'text-gray-400')));
@endphp

<div class="rounded-[3rem] p-10 shadow-xl shadow-green-900/[0.02] border {{ $wrapperBg }} relative overflow-hidden group hover:scale-[1.02] transition-all duration-500">
    @if($trend)
        <div class="absolute top-6 right-8 flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-black border border-green-100">
            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
            {{ $trend }}
        </div>
    @endif

    <div class="flex items-center gap-5 mb-8">
        <div class="w-14 h-14 {{ $iconBg }} rounded-[1.5rem] flex items-center justify-center {{ $iconText }} shadow-inner">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"></path></svg>
        </div>
        <p class="text-[10px] font-black {{ $titleText }} uppercase tracking-[0.2em] leading-none">{{ $title }}</p>
    </div>

    <div>
        <p class="text-5xl font-serif font-bold {{ $valueText }} mb-2 tracking-tight">{{ $value }}</p>
        <p class="text-xs {{ $labelText }} font-medium">{{ $label }}</p>
    </div>
</div>
