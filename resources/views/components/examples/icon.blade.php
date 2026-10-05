@props(['name'])

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes->merge(['class' => 'size-6']) }}>
    @switch($name)
        @case('box')
            <path d="M3 7.5 12 3l9 4.5-9 4.5L3 7.5Z" />
            <path d="M3 7.5V16.5L12 21l9-4.5V7.5" />
            <path d="M12 12v9" />
            @break
        @case('building')
            <path d="M4 20V6.5L12 3l8 3.5V20" />
            <path d="M9 20v-5h6v5" />
            <path d="M9 9h.01M12 9h.01M15 9h.01M9 12h.01M12 12h.01M15 12h.01" />
            @break
        @case('windows')
            <rect x="3" y="4" width="18" height="16" rx="1.5" />
            <path d="M12 4v16M3 12h18" />
            @break
        @case('roller')
            <path d="M4 8h12a2 2 0 0 1 2 2v2H4V8Z" />
            <path d="M18 10h2v3h-2" />
            <path d="M8 12v3M6 18h4" />
            @break
        @case('layers')
            <path d="M12 3 3 8l9 5 9-5-9-5Z" />
            <path d="m3 12 9 5 9-5" />
            <path d="m3 16 9 5 9-5" />
            @break
        @case('wrench')
            <path d="M14.5 6.5a4 4 0 0 0-5.6 5.1L4 16.5 7.5 20l4.9-4.9a4 4 0 0 0 5.1-5.6l-2.2 2.2-2-2 2.2-2.2Z" />
            @break
        @default
            <path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5Z" />
    @endswitch
</svg>
