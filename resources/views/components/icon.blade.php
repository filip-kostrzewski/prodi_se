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
        @default
            <path d="M4 12h16m-6-6 6 6-6 6" />
    @endswitch
</svg>
