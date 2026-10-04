<x-layouts.example :title="$title" :description="$description" theme="painting">
    @php
        $locale = app()->getLocale();
        $links = [
            'home' => 'example.painting',
            'services' => 'example.painting.services',
            'gallery' => 'example.painting.gallery',
            'contact' => 'example.painting.contact',
        ];
    @endphp

    <header class="mx-auto flex max-w-5xl flex-col gap-4 px-5 py-8">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.16em] text-ex-accent uppercase">{{ __('site.examples.disclaimer') }}</p>
                <p class="mt-2 font-serif text-3xl">{{ __('site.painting_site.name') }}</p>
            </div>
            <p class="text-sm text-ex-ink/70">{{ __('site.painting_site.tagline') }}</p>
        </div>
        <nav aria-label="{{ __('site.a11y.primary') }}" class="flex flex-wrap gap-2">
            @foreach ($links as $key => $route)
                <a
                    href="{{ \App\Support\Locales::urlFor($route, $locale) }}"
                    @if ($section === $key) aria-current="page" @endif
                    @class([
                        'rounded-full px-4 py-2 text-sm font-semibold',
                        'bg-ex-accent text-white' => $section === $key,
                        'border border-ex-line bg-ex-card' => $section !== $key,
                    ])
                >{{ __("site.painting_site.nav.$key") }}</a>
            @endforeach
        </nav>
    </header>

    @if ($section === 'home')
        <section class="mx-auto max-w-5xl px-5 pb-16">
            <div class="rounded-[2rem] bg-ex-ink px-6 py-10 text-ex-bg sm:px-10">
                <h1 class="max-w-xl font-serif text-4xl leading-tight text-balance sm:text-5xl">{{ __('site.painting_site.hero') }}</h1>
                <p class="mt-4 max-w-xl text-sm leading-6 text-ex-bg/80">{{ __('site.painting_site.lead') }}</p>
            </div>
        </section>
    @elseif ($section === 'services')
        <section class="mx-auto max-w-5xl px-5 pb-16">
            <h1 class="font-serif text-4xl">{{ __('site.painting_site.services_title') }}</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-ex-ink/75">{{ __('site.painting_site.services_intro') }}</p>
            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                @foreach (__('site.painting_site.services') as $service)
                    <article class="rounded-3xl border border-ex-line bg-ex-card p-5">
                        <h2 class="font-semibold">{{ $service['title'] }}</h2>
                        <p class="mt-2 text-sm leading-6 text-ex-ink/75">{{ $service['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @elseif ($section === 'gallery')
        <section class="mx-auto max-w-5xl px-5 pb-16">
            <h1 class="font-serif text-4xl">{{ __('site.painting_site.gallery_title') }}</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-ex-ink/75">{{ __('site.painting_site.gallery_intro') }}</p>
            <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (range(1, 6) as $tile)
                    <figure class="overflow-hidden rounded-3xl border border-ex-line bg-ex-card">
                        <svg viewBox="0 0 320 200" role="img" aria-label="{{ __('site.examples.photo_note') }}" class="h-40 w-full">
                            <rect width="320" height="200" fill="{{ $tile % 2 === 0 ? '#eadccb' : '#d7c3ae' }}" />
                            <rect x="36" y="28" width="248" height="120" fill="#fffdf8" />
                            <rect x="52" y="44" width="90" height="88" fill="{{ $tile % 3 === 0 ? '#8d4320' : '#c47a45' }}" />
                            <rect x="156" y="44" width="110" height="40" fill="#241910" opacity="0.15" />
                            <rect x="156" y="96" width="80" height="36" fill="#241910" opacity="0.28" />
                        </svg>
                        <figcaption class="px-4 py-3 text-xs leading-5 text-ex-ink/70">{{ __('site.examples.photo_note') }}</figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @else
        <section class="mx-auto max-w-5xl px-5 pb-16">
            <h1 class="font-serif text-4xl">{{ __('site.painting_site.contact_title') }}</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-ex-ink/75">{{ __('site.painting_site.contact_lead') }}</p>
            <p class="mt-6 max-w-2xl rounded-3xl border border-ex-line bg-ex-card p-6 text-sm leading-6">{{ __('site.examples.contact_note') }}</p>
        </section>
    @endif
</x-layouts.example>
