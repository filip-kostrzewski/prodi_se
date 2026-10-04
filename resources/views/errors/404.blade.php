@php
    app()->setLocale(request()->is('pl', 'pl/*') ? 'pl' : 'sv');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('site.errors.404_title') }} — Prodi</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-paper text-ink antialiased">
        <main class="mx-auto flex min-h-screen max-w-xl flex-col justify-center gap-4 px-5">
            <p class="font-serif text-3xl">prodi</p>
            <h1 class="font-serif text-4xl">{{ __('site.errors.404_title') }}</h1>
            <p class="text-muted">{{ __('site.errors.404_text') }}</p>
            <a class="inline-flex w-fit rounded-full bg-pine px-5 py-3 text-sm font-semibold text-paper" href="{{ \App\Support\Locales::urlFor('home', app()->getLocale()) }}">{{ __('site.errors.404_home') }}</a>
        </main>
    </body>
</html>
