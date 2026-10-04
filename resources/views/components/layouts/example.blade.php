@props(['title', 'description', 'theme' => 'cleaning'])

@php
    $locale = app()->getLocale();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">
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
        <div class="bg-ink text-paper">
            <div class="mx-auto flex max-w-5xl flex-col gap-2 px-5 py-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                <p>{{ __('site.examples.banner') }}</p>
                <a class="font-semibold underline decoration-white/40 underline-offset-4" href="{{ \App\Support\Locales::urlFor('home', $locale) }}#examples">{{ __('site.examples.back') }}</a>
            </div>
        </div>
        <main id="content">
            {{ $slot }}
        </main>
    </body>
</html>
