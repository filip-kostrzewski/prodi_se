@props(['name'])

<svg viewBox="0 0 360 200" fill="none" aria-hidden="true" {{ $attributes->merge(['class' => 'w-full']) }}>
    @switch($name)
        @case('website')
            <circle cx="180" cy="106" r="87" fill="#eadcc5" />
            <path d="M32 157c37 21 95 17 116-10s41-26 72-10 70 17 105-7" stroke="#d2b796" stroke-width="2" stroke-dasharray="5 6" />
            <g transform="rotate(-5 168 102)">
                <rect x="61" y="37" width="217" height="133" rx="10" fill="#fffefb" stroke="#14372b" stroke-width="2" />
                <path d="M61 57h217" stroke="#14372b" stroke-width="2" />
                <circle cx="74" cy="47" r="2" fill="#9a3d1c" /><circle cx="83" cy="47" r="2" fill="#d2b796" /><circle cx="92" cy="47" r="2" fill="#a3b99d" />
                <rect x="78" y="74" width="83" height="8" rx="4" fill="#14372b" />
                <rect x="78" y="91" width="64" height="8" rx="4" fill="#14372b" />
                <path d="M78 114h68m-68 9h51" stroke="#a3b99d" stroke-width="3" stroke-linecap="round" />
                <rect x="78" y="139" width="44" height="15" rx="7.5" fill="#9a3d1c" />
                <rect x="179" y="74" width="80" height="80" rx="30" fill="#a3b99d" />
                <path d="m189 139 19-23 14 14 11-13 17 22" fill="#14372b" /><circle cx="234" cy="96" r="8" fill="#fffefb" />
            </g>
            <g transform="rotate(8 271 133)">
                <rect x="246" y="86" width="53" height="98" rx="10" fill="#14372b" />
                <rect x="251" y="92" width="43" height="84" rx="6" fill="#fffefb" />
                <rect x="258" y="104" width="28" height="5" rx="2.5" fill="#14372b" />
                <rect x="258" y="116" width="28" height="31" rx="10" fill="#a3b99d" />
                <path d="M258 155h26m-26 6h18" stroke="#a3b99d" stroke-width="2" stroke-linecap="round" />
            </g>
            <path d="m303 40 3 11 11 3-11 3-3 11-3-11-11-3 11-3 3-11Z" fill="#9a3d1c" />
            @break
        @case('map')
            <circle cx="180" cy="105" r="87" fill="#dce7d8" />
            <g transform="rotate(4 176 111)">
                <rect x="63" y="53" width="231" height="121" rx="12" fill="#c6d6bf" />
                <path d="M78 53v121m72-121v121m88-121v121M63 92h231M63 143h231" stroke="#fffefb" stroke-width="11" />
                <path d="m75 164 71-55 84 21 57-57" stroke="#a3b99d" stroke-width="16" />
                <path d="m75 164 71-55 84 21 57-57" stroke="#fffefb" stroke-width="6" />
            </g>
            <rect x="82" y="25" width="197" height="37" rx="18.5" fill="#fffefb" stroke="#14372b" stroke-width="2" />
            <circle cx="101" cy="42" r="5" stroke="#14372b" stroke-width="2" /><path d="m105 46 4 4M119 44h105" stroke="#14372b" stroke-width="2" stroke-linecap="round" />
            <ellipse cx="181" cy="155" rx="24" ry="7" fill="#14372b" opacity=".12" />
            <path d="M210 109c0 24-29 46-29 46s-29-22-29-46a29 29 0 1 1 58 0Z" fill="#9a3d1c" stroke="#fffefb" stroke-width="3" />
            <circle cx="181" cy="108" r="10" fill="#fffefb" />
            <path d="M34 89c1-21 12-31 29-35m-7-3 9 2-5 8" stroke="#14372b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            @break
        @case('message')
            <circle cx="180" cy="105" r="87" fill="#f2d9ca" />
            <g transform="rotate(-5 167 103)">
                <rect x="89" y="32" width="154" height="148" rx="12" fill="#fffefb" stroke="#14372b" stroke-width="2" />
                <rect x="107" y="50" width="73" height="7" rx="3.5" fill="#14372b" />
                <rect x="106" y="73" width="118" height="22" rx="5" fill="#e8eee5" />
                <rect x="106" y="103" width="118" height="34" rx="5" fill="#e8eee5" />
                <path d="M117 84h42m-42 30h68m-68 10h49" stroke="#a3b99d" stroke-width="2" stroke-linecap="round" />
                <rect x="106" y="149" width="55" height="16" rx="8" fill="#14372b" /><path d="M141 157h10m-3-3 3 3-3 3" stroke="#fffefb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <g transform="rotate(9 256 106)">
                <rect x="211" y="76" width="90" height="61" rx="9" fill="#9a3d1c" stroke="#fffefb" stroke-width="3" />
                <path d="m214 80 42 30 42-30m-83 53 27-26m55 26-27-26" stroke="#fffefb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <path d="M270 158c22 0 42-14 44-36m-5 5 5-7 4 7" stroke="#14372b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path d="m64 58 3 10 10 3-10 3-3 10-3-10-10-3 10-3 3-10Z" fill="#9a3d1c" />
            @break
    @endswitch
</svg>
