@props(['name' => 'arrow'])

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes->merge(['class' => 'size-5 shrink-0']) }}>
    @switch($name)
        @case('check')
            <path d="m5 12 4 4L19 6" />
            @break
        @case('external')
            <path d="M6 18 18 6M6 6h12v12" />
            @break
        @case('menu')
            <path d="M4 8h16M4 16h16" />
            @break
        @case('website')
            <rect x="3" y="4" width="18" height="15" rx="2" />
            <path d="M3 9h18M7 6.5h.01M10 6.5h.01m-3 6h5m-5 3h9" />
            @break
        @case('layers')
            <path d="m12 3 9 5-9 5-9-5 9-5ZM3 12l9 5 9-5M3 16l9 5 9-5" />
            @break
        @case('pen')
            <path d="m15 4 5 5M4 20l5-1 12-12a2 2 0 0 0-5-5L4 14v6ZM4 14l5 5" />
            @break
        @case('chat')
            <path d="M21 11a8 8 0 0 1-8 8H8l-5 3v-6a8 8 0 0 1 0-10 9 9 0 0 1 18 5ZM7 9h10M7 13h6" />
            @break
        @case('send')
            <path d="m3 10 18-7-7 18-3-8-8-3Zm8 3 10-10" />
            @break
        @case('pin')
            <path d="M19 9c0 5-7 12-7 12S5 14 5 9a7 7 0 1 1 14 0Z" />
            <circle cx="12" cy="9" r="2.5" />
            @break
        @case('languages')
            <path d="M3 5h12M9 3v2M5 5c1 6 5 9 9 11M12 5c-1 6-5 9-9 11m11 5 4-11 4 11m-7-3h6" />
            @break
        @case('key')
            <circle cx="7.5" cy="8.5" r="4.5" />
            <path d="m11 12 9 9m-2-2 3-3m-6 0 3-3" />
            @break
        @case('building')
            <path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-5h6v5M9 8h.01M15 8h.01M9 12h.01M15 12h.01" />
            @break
        @case('sparkles')
            <path d="m9 3 2 6 6 2-6 2-2 6-2-6-6-2 6-2 2-6Zm10 11 1 3 3 1-3 1-1 3-1-3-3-1 3-1 1-3ZM18 3v5m-2.5-2.5h5" />
            @break
        @case('scissors')
            <circle cx="5.5" cy="6.5" r="3" />
            <circle cx="5.5" cy="17.5" r="3" />
            <path d="m8 8 13 12M8 16 21 4" />
            @break
        @case('tools')
            <path d="M14 5a6 6 0 0 0-7 8l-4 4a2.8 2.8 0 0 0 4 4l4-4a6 6 0 0 0 8-7l-4 4-4-4 3-5Z" />
            @break
        @case('truck')
            <path d="M3 16V5h12v11M15 9h4l3 4v3h-3M7 16h8" />
            <circle cx="5" cy="18" r="2" /><circle cx="17" cy="18" r="2" />
            @break
        @case('shop')
            <path d="M4 10v11h16V10M3 10l2-7h14l2 7M3 10a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0M9 21v-7h6v7" />
            @break
        @default
            <path d="M4 12h16m-6-6 6 6-6 6" />
    @endswitch
</svg>
