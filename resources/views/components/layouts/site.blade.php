@props(['title', 'description'])

@php
    $locale = app()->getLocale();
    $page = \App\Support\Locales::currentPage() ?? 'home';
    $home = \App\Support\Locales::urlFor('home', $locale);
    $contact = \App\Support\Locales::urlFor('contact', $locale);
    $privacy = \App\Support\Locales::urlFor('privacy', $locale);
    $orgNumber = \App\Support\Company::orgNumber();
    $streetLine = \App\Support\Company::streetLine();
    $email = \App\Support\Company::publishedContactEmail();
    $phone = \App\Support\Company::phone();
    $phoneHref = \App\Support\Company::phoneHref();
    $whatsappHref = \App\Support\Company::whatsappHref();
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
    <body class="bg-paper text-ink antialiased">
        <a href="#content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:rounded-full focus:bg-card focus:px-4 focus:py-2">
            {{ __('site.a11y.skip') }}
        </a>

        <header class="sticky top-0 z-40 border-b border-line/80 bg-paper/90 backdrop-blur-md">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-3">
                <a href="{{ $home }}" class="font-serif text-2xl leading-none tracking-tight">prodi</a>

                <nav aria-label="{{ __('site.a11y.primary') }}" class="hidden items-center gap-6 text-sm text-muted md:flex">
                    <a class="hover:text-ink" href="{{ $home }}#packages">{{ __('site.nav.packages') }}</a>
                    <a class="hover:text-ink" href="{{ $home }}#process">{{ __('site.nav.process') }}</a>
                    <a class="hover:text-ink" href="{{ $home }}#examples">{{ __('site.nav.examples') }}</a>
                    <a class="hover:text-ink" href="{{ $home }}#faq">{{ __('site.nav.faq') }}</a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3">
                    <nav aria-label="{{ __('site.a11y.language') }}" class="flex items-center rounded-full border border-line bg-card p-1 text-xs font-semibold tracking-wide">
                        @foreach (\App\Support\Locales::DEFINITIONS as $code => $definition)
                            <a
                                href="{{ \App\Support\Locales::urlFor($page, $code) }}"
                                hreflang="{{ $definition['hreflang'] }}"
                                lang="{{ $code }}"
                                aria-label="{{ $definition['name'] }}"
                                @if ($locale === $code) aria-current="page" @endif
                                @class([
                                    'rounded-full px-2.5 py-1',
                                    'bg-pine text-paper' => $locale === $code,
                                    'text-muted hover:text-ink' => $locale !== $code,
                                ])
                            >{{ $definition['label'] }}</a>
                        @endforeach
                    </nav>

                    @if ($phoneHref)
                        <a href="{{ $phoneHref }}" class="hidden text-sm font-semibold hover:underline lg:inline">{{ $phone }}</a>
                    @endif

                    <a href="{{ $contact }}#offert" class="inline-flex rounded-full bg-pine px-3 py-2 text-sm font-semibold text-paper hover:bg-pine-deep sm:px-4">
                        {{ __('site.nav.contact') }}
                    </a>

                    <details class="relative md:hidden">
                        <summary class="cursor-pointer rounded-full border border-line bg-card px-3 py-2 text-sm font-semibold">
                            {{ __('site.a11y.menu') }}
                        </summary>
                        <nav aria-label="{{ __('site.a11y.primary') }}" class="absolute right-0 z-50 mt-2 flex w-52 flex-col gap-1 rounded-2xl border border-line bg-card p-3 text-sm shadow-lg">
                            <a class="rounded-lg px-3 py-2 hover:bg-paper" href="{{ $home }}#packages">{{ __('site.nav.packages') }}</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-paper" href="{{ $home }}#process">{{ __('site.nav.process') }}</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-paper" href="{{ $home }}#examples">{{ __('site.nav.examples') }}</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-paper" href="{{ $home }}#faq">{{ __('site.nav.faq') }}</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-paper" href="{{ $contact }}">{{ __('site.nav.contact') }}</a>
                        </nav>
                    </details>
                </div>
            </div>
        </header>

        <main id="content">
            {{ $slot }}
        </main>

        <footer class="border-t border-line">
            <div class="mx-auto grid max-w-6xl gap-8 px-5 py-12 md:grid-cols-[1.4fr_1fr]">
                <div class="flex flex-col gap-3">
                    <p class="font-serif text-2xl">prodi</p>
                    <p class="max-w-md text-sm leading-6 text-muted">{{ __('site.footer.blurb') }}</p>
                    <p class="text-sm text-muted">{{ __('site.footer.prices') }}</p>
                    @if ($orgNumber)
                        <p class="text-sm text-muted">{{ __('site.footer.org_number', ['number' => $orgNumber]) }}</p>
                    @endif
                    @if ($streetLine)
                        <p class="text-sm text-muted">{{ $streetLine }}, {{ \App\Support\Company::city() }}</p>
                    @endif
                    @if ($email)
                        <p class="text-sm"><a class="underline decoration-line underline-offset-4" href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endif
                    @if ($phoneHref)
                        <p class="flex flex-wrap gap-x-4 gap-y-1 text-sm">
                            <a class="font-semibold underline decoration-line underline-offset-4" href="{{ $phoneHref }}">{{ $phone }}</a>
                            @if ($whatsappHref)
                                <a class="font-semibold underline decoration-line underline-offset-4" href="{{ $whatsappHref }}">WhatsApp</a>
                            @endif
                        </p>
                    @endif
                </div>
                <nav aria-label="{{ __('site.a11y.primary') }}" class="flex flex-col gap-2 text-sm md:items-end">
                    <a class="hover:underline" href="{{ $contact }}">{{ __('site.nav.contact') }}</a>
                    <a class="hover:underline" href="{{ $home }}#examples">{{ __('site.nav.examples') }}</a>
                    <a class="hover:underline" href="{{ $privacy }}">{{ __('site.nav.privacy') }}</a>
                </nav>
            </div>
            <div class="border-t border-line">
                <p class="mx-auto max-w-6xl px-5 py-4 text-xs text-muted">© {{ now()->year }} {{ __('site.footer.rights') }}</p>
            </div>
        </footer>
    </body>
</html>
