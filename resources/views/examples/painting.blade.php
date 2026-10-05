<x-layouts.example :title="$title" :description="$description" theme="painting" quote-package="firma">
    @php
        $locale = app()->getLocale();
        $links = [
            'home' => 'example.painting',
            'services' => 'example.painting.services',
            'gallery' => 'example.painting.gallery',
            'contact' => 'example.painting.contact',
        ];
        $gallery = __('site.painting_site.gallery');
    @endphp

    <x-slot:header>
        <header class="border-b border-ex-line bg-ex-card/95 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-3">
                <a href="{{ \App\Support\Locales::urlFor('example.painting', $locale) }}" class="font-serif text-2xl leading-none">{{ __('site.painting_site.name') }}</a>
                <a href="{{ __('site.examples.demo.phone_href') }}" class="inline-flex rounded-full bg-ex-accent px-4 py-2 text-sm font-semibold text-white">
                    {{ __('site.examples.demo.call') }} {{ __('site.examples.demo.phone_display') }}
                </a>
            </div>
            <nav aria-label="{{ __('site.a11y.primary') }}" class="mx-auto grid max-w-6xl grid-cols-4 text-center text-sm font-semibold">
                @foreach ($links as $key => $route)
                    <a
                        href="{{ \App\Support\Locales::urlFor($route, $locale) }}"
                        @if ($section === $key) aria-current="page" @endif
                        @class([
                            'border-t px-2 py-3',
                            'border-ex-accent bg-ex-soft text-ex-ink' => $section === $key,
                            'border-ex-line text-ex-muted hover:bg-ex-soft hover:text-ex-ink' => $section !== $key,
                        ])
                    >{{ __("site.painting_site.nav.$key") }}</a>
                @endforeach
            </nav>
        </header>
    </x-slot:header>

    @if ($section === 'home')
        <section class="relative isolate min-h-[32rem] overflow-hidden">
            <img src="{{ asset('images/examples/painting-hero.jpg') }}" alt="{{ __('site.painting_site.hero_alt') }}" width="1600" height="1117" fetchpriority="high" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-[#3a160c]/92 via-[#3a160c]/72 to-[#3a160c]/25"></div>
            <div class="relative mx-auto flex min-h-[32rem] max-w-6xl flex-col justify-end px-5 py-12 sm:py-16">
                <p class="text-sm font-semibold tracking-wide text-white/90">{{ __('site.examples.disclaimer') }}</p>
                <h1 class="mt-3 max-w-2xl font-serif text-4xl leading-[1.08] text-balance text-white sm:text-6xl">{{ __('site.painting_site.hero') }}</h1>
                <p class="mt-4 max-w-xl text-lg leading-8 text-white">{{ __('site.painting_site.lead') }}</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ __('site.examples.demo.phone_href') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3.5 text-base font-semibold text-[#3a160c]">{{ __('site.examples.demo.call') }} {{ __('site.examples.demo.phone_display') }}</a>
                    <a href="{{ \App\Support\Locales::quoteUrl('firma') }}" class="inline-flex items-center justify-center rounded-full border border-white/80 px-6 py-3.5 text-base font-semibold text-white">{{ __('site.examples.demo.quote') }}</a>
                </div>
            </div>
        </section>

        <section class="border-b border-ex-line bg-ex-card">
            <dl class="mx-auto grid max-w-6xl gap-6 px-5 py-6 sm:grid-cols-3">
                <div>
                    <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.hours_label') }}</dt>
                    <dd class="mt-1 text-base">{{ __('site.examples.demo.hours') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.area_label') }}</dt>
                    <dd class="mt-1 text-base">{{ __('site.painting_site.area') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.stars_label') }}</dt>
                    <dd class="mt-1">
                        <span aria-hidden="true" class="tracking-tight text-ex-accent">★★★★★</span>
                        <span class="mt-1 block text-sm leading-6 text-ex-muted">{{ __('site.examples.demo.stars_note') }}</span>
                    </dd>
                </div>
            </dl>
        </section>

        <section class="mx-auto max-w-6xl px-5 py-16">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="font-serif text-4xl">{{ __('site.painting_site.photos_title') }}</h2>
                    <p class="mt-3 max-w-2xl text-lg leading-8 text-ex-muted">{{ __('site.painting_site.photos_text') }}</p>
                </div>
                <a href="{{ \App\Support\Locales::urlFor('example.painting.gallery', $locale) }}" class="hidden shrink-0 rounded-full bg-ex-accent px-4 py-2 text-sm font-semibold text-white sm:inline-flex">{{ __('site.painting_site.nav.gallery') }}</a>
            </div>
            <div class="mt-8 grid gap-3 sm:grid-cols-3">
                @foreach (array_slice($gallery, 0, 3) as $photo)
                    <figure class="overflow-hidden rounded-3xl">
                        <img src="{{ asset('images/examples/'.$photo['file']) }}" alt="{{ $photo['alt'] }}" width="1200" height="800" loading="lazy" class="aspect-[4/3] w-full object-cover">
                    </figure>
                @endforeach
            </div>
        </section>

        <section class="border-t border-ex-line bg-ex-card">
            <div class="mx-auto grid max-w-6xl gap-4 px-5 py-16 sm:grid-cols-2">
                @foreach (__('site.painting_site.services') as $service)
                    <article class="rounded-3xl bg-ex-bg p-6">
                        <span class="flex size-12 items-center justify-center rounded-2xl bg-ex-soft text-ex-accent">
                            <x-examples.icon :name="$service['icon']" />
                        </span>
                        <h2 class="mt-4 font-serif text-2xl">{{ $service['title'] }}</h2>
                        <p class="mt-2 text-base leading-7 text-ex-muted">{{ $service['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @elseif ($section === 'services')
        <section class="relative isolate overflow-hidden">
            <img src="{{ asset('images/examples/painting-roller.jpg') }}" alt="{{ $gallery[5]['alt'] }}" width="1200" height="675" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-[#3a160c]/75"></div>
            <div class="relative mx-auto max-w-6xl px-5 py-16">
                <h1 class="max-w-2xl font-serif text-4xl text-white sm:text-5xl">{{ __('site.painting_site.services_title') }}</h1>
                <p class="mt-4 max-w-2xl text-lg leading-8 text-white">{{ __('site.painting_site.services_intro') }}</p>
            </div>
        </section>
        <section class="mx-auto grid max-w-6xl gap-4 px-5 py-16">
            @foreach (__('site.painting_site.services') as $service)
                <article class="grid gap-4 rounded-3xl bg-ex-card p-6 ring-1 ring-ex-line sm:grid-cols-[auto_1fr_auto] sm:items-center">
                    <span class="flex size-12 items-center justify-center rounded-2xl bg-ex-soft text-ex-accent">
                        <x-examples.icon :name="$service['icon']" />
                    </span>
                    <div>
                        <h2 class="font-serif text-2xl">{{ $service['title'] }}</h2>
                        <p class="mt-2 text-base leading-7 text-ex-muted">{{ $service['text'] }}</p>
                    </div>
                    <p class="w-fit rounded-full bg-ex-soft px-3 py-1 text-sm font-semibold text-ex-accent">{{ __('site.painting_site.quote_chip') }}</p>
                </article>
            @endforeach
        </section>
    @elseif ($section === 'gallery')
        <section class="mx-auto max-w-6xl px-5 py-16">
            <h1 class="font-serif text-4xl sm:text-5xl">{{ __('site.painting_site.gallery_title') }}</h1>
            <p class="mt-4 max-w-2xl text-lg leading-8 text-ex-muted">{{ __('site.painting_site.gallery_intro') }}</p>
            <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($gallery as $photo)
                    <figure class="overflow-hidden rounded-3xl bg-ex-card ring-1 ring-ex-line">
                        <img src="{{ asset('images/examples/'.$photo['file']) }}" alt="{{ $photo['alt'] }}" width="1200" height="800" loading="lazy" class="aspect-[4/3] w-full object-cover">
                    </figure>
                @endforeach
            </div>
        </section>
    @else
        <section class="mx-auto grid max-w-6xl items-center gap-8 px-5 py-16 lg:grid-cols-2">
            <img src="{{ asset('images/examples/painting-house.jpg') }}" alt="{{ $gallery[4]['alt'] }}" width="1200" height="800" class="aspect-[4/3] w-full rounded-[2rem] object-cover">
            <div>
                <h1 class="font-serif text-4xl sm:text-5xl">{{ __('site.painting_site.contact_title') }}</h1>
                <p class="mt-4 text-lg leading-8 text-ex-muted">{{ __('site.painting_site.contact_lead') }}</p>
                <dl class="mt-8 flex flex-col gap-4 text-base">
                    <div>
                        <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.phone_label') }}</dt>
                        <dd class="mt-1"><a class="text-2xl font-semibold underline decoration-ex-line underline-offset-4" href="{{ __('site.examples.demo.phone_href') }}">{{ __('site.examples.demo.phone_display') }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.email_label') }}</dt>
                        <dd class="mt-1"><a class="text-lg font-semibold underline decoration-ex-line underline-offset-4" href="mailto:{{ __('site.examples.demo.email') }}">{{ __('site.examples.demo.email') }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.hours_label') }}</dt>
                        <dd class="mt-1">{{ __('site.examples.demo.hours') }}</dd>
                    </div>
                </dl>
                <a href="{{ \App\Support\Locales::quoteUrl('firma') }}" class="mt-8 inline-flex rounded-full bg-ex-accent px-5 py-3 text-sm font-semibold text-white">{{ __('site.examples.demo.quote') }}</a>
            </div>
        </section>
    @endif
</x-layouts.example>
