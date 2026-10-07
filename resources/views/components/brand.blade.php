@props(['size' => 'md'])

@php
    $iconClass = $size === 'lg' ? 'h-12 w-12' : 'h-9 w-9';
    $textClass = $size === 'lg' ? 'text-3xl' : 'text-2xl';
@endphp

<span {{ $attributes->class('inline-flex items-center gap-2.5') }}>
    <picture class="shrink-0">
        <source srcset="{{ asset('images/prodi-icon.webp') }}" type="image/webp">
        <img src="{{ asset('images/prodi-icon.png') }}" alt="" width="131" height="166" class="{{ $iconClass }} object-contain">
    </picture>
    <span class="{{ $textClass }} font-sans leading-none tracking-tight">
        <span class="font-medium text-muted">Pro</span><span class="font-semibold text-ink">di</span>
    </span>
</span>
