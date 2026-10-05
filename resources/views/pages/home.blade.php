<x-layouts.site :title="$title" :description="$description">
    <section class="mx-auto grid max-w-6xl gap-10 px-5 py-14 lg:grid-cols-12 lg:items-end lg:py-20">
        <div class="flex flex-col gap-6 lg:col-span-7">
            <p class="text-sm font-medium tracking-wide text-clay">{{ __('site.hero.eyebrow') }}</p>
            <h1 class="font-serif text-4xl leading-[1.15] text-balance sm:text-5xl">{{ __('site.hero.title') }}</h1>
            <p class="max-w-xl text-lg leading-8 text-muted">{{ __('site.hero.lead') }}</p>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ \App\Support\Locales::urlFor('contact', app()->getLocale()) }}" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-sm font-semibold text-paper hover:bg-pine-deep">
                    {{ __('site.hero.primary') }}
                </a>
                <a href="#packages" class="inline-flex items-center justify-center rounded-full border border-line bg-card px-6 py-3 text-sm font-semibold hover:border-ink">
                    {{ __('site.hero.secondary') }}
                </a>
            </div>
        </div>

        <aside class="rounded-[2rem] bg-pine px-7 py-8 text-paper shadow-xl lg:col-span-5">
            <p class="text-sm uppercase tracking-[0.18em] text-mist">{{ __('site.hero.price_from') }}</p>
            <p class="mt-2 font-serif text-6xl leading-none">{{ __('site.hero.price') }}</p>
            <p class="mt-3 text-sm text-mist">{{ __('site.hero.price_note') }}</p>
            <ul class="mt-8 flex flex-col gap-3 text-sm leading-6">
                @foreach (__('site.hero.facts') as $fact)
                    <li class="border-t border-white/15 pt-3">{{ $fact }}</li>
                @endforeach
            </ul>
        </aside>
    </section>

    <section class="border-y border-line" aria-label="{{ __('site.audience.label') }}">
        <div class="mx-auto flex max-w-6xl flex-col gap-4 px-5 py-6 lg:flex-row lg:items-center lg:justify-between">
            <p class="max-w-xl text-sm leading-6 text-muted">{{ __('site.audience.text') }}</p>
            <ul class="flex flex-wrap gap-2">
                @foreach (__('site.audience.trades') as $trade)
                    <li class="rounded-full border border-line bg-card px-3 py-1 text-sm">{{ $trade }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    <section id="packages" class="scroll-mt-24 mx-auto max-w-6xl px-5 py-16 lg:py-24">
        <div class="max-w-2xl">
            <h2 class="font-serif text-4xl text-balance">{{ __('site.packages.title') }}</h2>
            <p class="mt-4 text-lg leading-8 text-muted">{{ __('site.packages.intro') }}</p>
        </div>

        <div class="mt-10 grid gap-4 lg:grid-cols-3">
            @foreach (['start', 'firma', 'individual'] as $key)
                <article @class([
                    'flex flex-col gap-5 rounded-3xl p-6',
                    'bg-pine text-paper' => $key === 'firma',
                    'border border-line bg-card' => $key !== 'firma',
                ])>
                    <div>
                        <h3 class="font-serif text-3xl">{{ __("site.packages.names.$key") }}</h3>
                        <p class="mt-4 font-serif text-4xl">{{ __("site.packages.$key.price") }}</p>
                        <p @class(['mt-1 text-sm', 'text-mist' => $key === 'firma', 'text-muted' => $key !== 'firma'])>{{ __("site.packages.$key.cadence") }}</p>
                    </div>
                    <p @class(['text-base leading-7', 'text-mist' => $key === 'firma', 'text-muted' => $key !== 'firma'])>{{ __("site.packages.$key.fit") }}</p>
                    <ul class="flex flex-col gap-2 text-base leading-7">
                        @foreach (__("site.packages.$key.points") as $point)
                            <li class="flex gap-2"><span aria-hidden="true" @class(['text-pine' => $key !== 'firma'])>–</span><span>{{ $point }}</span></li>
                        @endforeach
                    </ul>
                    <a href="{{ \App\Support\Locales::quoteUrl($key) }}" @class([
                        'mt-auto inline-flex items-center justify-center rounded-full px-5 py-3 text-sm font-semibold',
                        'bg-paper text-pine hover:bg-mist' => $key === 'firma',
                        'bg-pine text-paper hover:bg-pine-deep' => $key !== 'firma',
                    ])>{{ __('site.packages.choose') }}</a>
                </article>
            @endforeach
        </div>

        <article class="mt-4 grid gap-6 rounded-3xl border border-line bg-card p-6 md:grid-cols-[16rem_1fr] md:items-center">
            <div>
                <h3 class="font-serif text-3xl">{{ __('site.packages.names.opieka') }}</h3>
                <p class="mt-3 font-serif text-4xl">{{ __('site.packages.opieka.price') }}</p>
                <p class="mt-1 text-sm text-muted">{{ __('site.packages.opieka.cadence') }}</p>
            </div>
            <div class="flex flex-col gap-4">
                <p class="text-base leading-7 text-muted">{{ __('site.packages.opieka.fit') }}</p>
                <ul class="grid gap-2 text-base leading-7 sm:grid-cols-3">
                    @foreach (__('site.packages.opieka.points') as $point)
                        <li class="rounded-2xl bg-paper px-3 py-3">{{ $point }}</li>
                    @endforeach
                </ul>
                <a href="{{ \App\Support\Locales::quoteUrl('opieka') }}" class="inline-flex w-fit items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold text-paper hover:bg-pine-deep">{{ __('site.packages.choose') }}</a>
            </div>
        </article>

        <p class="mt-6 max-w-3xl text-sm leading-6 text-muted">{{ __('site.packages.domain') }}</p>
    </section>

    <section id="process" class="scroll-mt-24 border-y border-line bg-card">
        <div class="mx-auto grid max-w-6xl gap-12 px-5 py-16 lg:grid-cols-2 lg:py-24">
            <div>
                <h2 class="font-serif text-4xl text-balance">{{ __('site.process.title') }}</h2>
                <p class="mt-4 text-lg leading-8 text-muted">{{ __('site.process.intro') }}</p>
                <ol class="mt-8 flex flex-col gap-6">
                    @foreach (__('site.process.steps') as $step)
                        <li class="grid grid-cols-[2.5rem_1fr] gap-3">
                            <span class="font-serif text-2xl text-clay">{{ $loop->iteration }}</span>
                            <div>
                                <h3 class="font-semibold">{{ $step['title'] }}</h3>
                                <p class="mt-1 text-sm leading-6 text-muted">{{ $step['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="rounded-[2rem] bg-paper p-6 lg:p-8">
                <h2 class="font-serif text-3xl text-balance">{{ __('site.provide.title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-muted">{{ __('site.provide.intro') }}</p>
                <ul class="mt-6 flex flex-col gap-3 text-sm leading-6">
                    @foreach (__('site.provide.items') as $item)
                        <li class="border-b border-line pb-3">{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section id="why" class="scroll-mt-24 mx-auto max-w-6xl px-5 py-16 lg:py-24">
        <h2 class="font-serif text-4xl">{{ __('site.why.title') }}</h2>
        <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (__('site.why.items') as $item)
                <article class="border-t border-ink pt-4">
                    <h3 class="font-serif text-2xl">{{ $item['title'] }}</h3>
                    <p class="mt-3 text-sm leading-6 text-muted">{{ $item['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="examples" class="scroll-mt-24 border-y border-line bg-mist/60">
        <div class="mx-auto max-w-6xl px-5 py-16 lg:py-24">
            <h2 class="font-serif text-4xl text-balance">{{ __('site.examples.title') }}</h2>
            <p class="mt-4 max-w-2xl text-lg leading-8 text-muted">{{ __('site.examples.intro') }}</p>
            <div class="mt-10 grid gap-4 lg:grid-cols-2">
                @foreach ([
                    'cleaning' => ['route' => 'example.cleaning', 'image' => 'images/examples/cleaning-hero.jpg'],
                    'painting' => ['route' => 'example.painting', 'image' => 'images/examples/painting-hero.jpg'],
                ] as $key => $example)
                    <a href="{{ \App\Support\Locales::urlFor($example['route'], app()->getLocale()) }}" class="group flex flex-col overflow-hidden rounded-3xl border border-line bg-card">
                        <img
                            src="{{ asset($example['image']) }}"
                            alt="{{ __("site.examples.preview_$key") }}"
                            width="1600"
                            height="1067"
                            loading="lazy"
                            class="aspect-[16/10] w-full object-cover motion-safe:transition motion-safe:duration-500 motion-safe:group-hover:scale-[1.03]"
                        >
                        <div class="flex flex-1 flex-col gap-3 p-5">
                            <p class="text-xs font-semibold tracking-wide text-clay uppercase">{{ __("site.examples.$key.kicker") }}</p>
                            <h3 class="font-serif text-2xl">{{ __("site.examples.$key.title") }}</h3>
                            <p class="text-base leading-7 text-muted">{{ __("site.examples.$key.text") }}</p>
                            <span class="mt-auto inline-flex w-fit rounded-full bg-ink px-5 py-2.5 text-sm font-semibold text-paper">{{ __('site.examples.open') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="faq" class="scroll-mt-24 mx-auto max-w-3xl px-5 py-16 lg:py-24">
        <h2 class="font-serif text-4xl">{{ __('site.faq.title') }}</h2>
        <div class="mt-8 divide-y divide-line border-y border-line">
            @foreach (__('site.faq.items') as $item)
                <details class="group py-4">
                    <summary class="flex cursor-pointer items-center justify-between gap-4 font-semibold">
                        <span>{{ $item['q'] }}</span>
                        <span aria-hidden="true" class="text-clay group-open:hidden">+</span>
                        <span aria-hidden="true" class="hidden text-clay group-open:inline">–</span>
                    </summary>
                    <p class="pt-3 pr-8 text-sm leading-6 text-muted">{{ $item['a'] }}</p>
                </details>
            @endforeach
        </div>
    </section>

    <section class="px-5 pb-16">
        <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 rounded-[2rem] bg-pine px-7 py-10 text-paper md:flex-row md:items-center">
            <div class="max-w-xl">
                <h2 class="font-serif text-4xl text-balance">{{ __('site.closing.title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-mist">{{ __('site.closing.text') }}</p>
            </div>
            <a href="{{ \App\Support\Locales::urlFor('contact', app()->getLocale()) }}" class="inline-flex rounded-full bg-paper px-6 py-3 text-sm font-semibold text-pine hover:bg-mist">
                {{ __('site.closing.button') }}
            </a>
        </div>
    </section>
</x-layouts.site>
