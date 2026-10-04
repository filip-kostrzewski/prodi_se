@props(['title', 'description'])

@php
    $locale = app()->getLocale();
    $alternates = \App\Support\Locales::alternateUrls();
    $canonical = $alternates[$locale] ?? url()->current();
    $image = asset('images/og.png');
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">
@foreach ($alternates as $code => $href)
    <link rel="alternate" hreflang="{{ \App\Support\Locales::DEFINITIONS[$code]['hreflang'] }}" href="{{ $href }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ $alternates[\App\Support\Locales::DEFAULT] }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ \App\Support\Company::name() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:locale" content="{{ \App\Support\Locales::DEFINITIONS[$locale]['og'] }}">
@foreach (\App\Support\Locales::DEFINITIONS as $code => $definition)
    @if ($code !== $locale)
        <meta property="og:locale:alternate" content="{{ $definition['og'] }}">
    @endif
@endforeach
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ \App\Support\Company::name() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<meta name="theme-color" content="#14372b">
<script type="application/ld+json">
@json(\App\Support\StructuredData::forPage($title, $description))
</script>
