@props(['title', 'description', 'theme' => 'cleaning', 'quotePackage' => 'start'])

@php
    $locale = app()->getLocale();
    $page = \App\Support\Locales::currentPage() ?? 'example.cleaning';
    $quote = \App\Support\Locales::quoteUrl($quotePackage, $locale);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <x-seo-head :title="$title" :description="$description" />
        @fonts
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body data-theme="{{ $theme }}" class="bg-ex-bg text-ex-ink antialiased">
        <a href="#content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:rounded-full focus:bg-ex-card focus:px-4 focus:py-2">
            {{ __('site.a11y.skip') }}
        </a>

        <div class="sticky top-0 z-50">
            <div class="bg-ink text-paper">
                <div class="mx-auto flex max-w-6xl flex-col gap-3 px-5 py-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                    <p>{{ __('site.examples.banner') }}</p>
                    <div class="flex flex-wrap items-center gap-2">
                        <nav aria-label="{{ __('site.a11y.language') }}" class="flex items-center rounded-full bg-white/10 p-1 text-xs font-semibold">
                            @foreach (\App\Support\Locales::DEFINITIONS as $code => $definition)
                                <a
                                    href="{{ \App\Support\Locales::urlFor($page, $code) }}"
                                    hreflang="{{ $definition['hreflang'] }}"
                                    lang="{{ $code }}"
                                    aria-label="{{ $definition['name'] }}"
                                    @if ($locale === $code) aria-current="page" @endif
                                    @class([
                                        'rounded-full px-2.5 py-1',
                                        'bg-paper text-ink' => $locale === $code,
                                        'text-paper hover:bg-white/10' => $locale !== $code,
                                    ])
                                >{{ $definition['label'] }}</a>
                            @endforeach
                        </nav>
                        <a href="{{ $quote }}" class="inline-flex rounded-full bg-paper px-4 py-2 text-sm font-semibold text-ink">{{ __('site.examples.demo.quote') }}</a>
                        <a class="font-semibold underline decoration-white/40 underline-offset-4" href="{{ \App\Support\Locales::urlFor('home', $locale) }}#examples">{{ __('site.examples.back') }}</a>
                    </div>
                </div>
            </div>
            {{ $header ?? '' }}
        </div>

        <main id="content">
            {{ $slot }}
        </main>

        <footer class="border-t border-ex-line">
            <div class="bg-ex-accent text-white">
                <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-4 px-5 py-8 sm:flex-row sm:items-center">
                    <p class="max-w-xl font-serif text-3xl">{{ __('site.examples.demo.quote') }}</p>
                    <a href="{{ $quote }}" class="inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-ex-ink">{{ __('site.examples.demo.quote') }}</a>
                </div>
            </div>
            <div class="mx-auto flex max-w-6xl flex-col gap-2 px-5 py-6 text-sm text-ex-muted sm:flex-row sm:items-center sm:justify-between">
                <p>{{ __('site.examples.photo_credit') }}</p>
                <a class="font-semibold text-ex-ink underline decoration-ex-line underline-offset-4" href="{{ \App\Support\Locales::urlFor('home', $locale) }}#examples">{{ __('site.examples.back') }}</a>
            </div>
        </footer>
    </body>
</html>
