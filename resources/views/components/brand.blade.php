@props(['size' => 'md'])

@php
    $iconClass = $size === 'lg' ? 'h-12 w-12' : 'h-9 w-9';
    $textClass = $size === 'lg' ? 'text-3xl' : 'text-2xl';
@endphp

<span {{ $attributes->class('inline-flex items-center gap-2.5') }}>
    <img src="{{ asset('images/prodi-icon.png') }}" alt="" width="115" height="150" class="{{ $iconClass }} shrink-0 object-contain">
    <span class="{{ $textClass }} font-sans leading-none tracking-tight">
        <span class="font-medium text-[#8a8580]">Pro</span><span class="font-semibold text-ink">di</span>
    </span>
</span>
