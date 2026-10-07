<x-layouts.site :title="$title" :description="$description">
    <section class="site-container pt-10 pb-10 lg:pt-14 lg:pb-12">
        <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_1fr] lg:gap-14">
            <div>
                <p class="eyebrow text-pine">{{ __('site.hero.eyebrow') }}</p>
                <h1 class="hero-title mt-7">
                    <span class="block">{{ __('site.hero.title') }}</span>
                    <span class="hero-highlight italic text-pine">
                        {{ __('site.hero.title_highlight') }}
                        <svg class="hero-underline" viewBox="0 0 400 16" preserveAspectRatio="none" fill="none" aria-hidden="true"><path d="M3 10C99 1 260 1 397 7M61 15c113-6 226-7 290-3" stroke="currentColor" stroke-width="3" stroke-linecap="round" /></svg>
                    </span>
                </h1>
                <p class="mt-6 max-w-lg text-base leading-7 text-muted sm:text-lg sm:leading-8">{{ __('site.hero.lead') }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ \App\Support\Locales::urlFor('contact', app()->getLocale()) }}" class="site-button bg-pine text-paper hover:bg-pine-deep">
                        {{ __('site.hero.primary') }}
                        <x-icon />
                    </a>
                    <a href="#packages" class="site-button border border-line bg-card hover:border-pine">
                        {{ __('site.hero.secondary') }}
                    </a>
                </div>
            </div>

            <aside class="hero-showcase" aria-label="{{ __('site.examples.work.evasstad.kicker') }}">
                <svg class="hero-drawing" viewBox="0 0 540 500" fill="none" aria-hidden="true">
                    <path d="M70 177c-18-77 38-128 124-138M43 211C19 114 62 53 151 24" stroke="#a3b99d" stroke-width="2" stroke-linecap="round" />
                    <path d="M192 68c91-38 216 15 251 121m-58-42 45 18-12-47" stroke="#a3b99d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M392 34c6 28 19 35 44 38-25 3-38 12-44 39-6-27-19-36-44-39 25-3 38-10 44-38Z" fill="#9a3d1c" />
                    <path d="M474 369c3 15 10 20 25 22-15 2-22 7-25 22-4-15-11-20-26-22 15-2 22-7 26-22Z" fill="#d2b796" />
                    <path d="M293 473c62-5 102-34 113-60m-3 12 4-13 8 10" stroke="#9a3d1c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="hero-caption"><x-icon name="sparkles" class="size-4 text-clay" />{{ __('site.hero.showcase_label') }}</p>
                <a href="https://evasstad.se" target="_blank" rel="noopener noreferrer" class="project-window block">
                    <div class="window-toolbar" aria-hidden="true">
                        <i></i><i></i><i></i><span>evasstad.se</span>
                    </div>
                    <picture>
                        <source
                            type="image/webp"
                            srcset="{{ asset('images/work/evasstad-640.webp') }} 640w, {{ asset('images/work/evasstad-960.webp') }} 960w"
                            sizes="(min-width: 1280px) 484px, (min-width: 1024px) 42vw, (min-width: 640px) 82vw, calc(88vw - 36px)"
                        >
                        <img src="{{ asset('images/work/evasstad.jpg') }}" alt="{{ __('site.examples.work.evasstad.image_alt') }}" width="1600" height="1000" fetchpriority="high" class="aspect-[16/10] w-full object-cover object-top">
                    </picture>
                    <span class="sr-only">{{ __('site.examples.work.evasstad.open') }} ({{ __('site.examples.new_tab') }})</span>
                </a>
                <div class="hero-phone" aria-hidden="true">
                    <img
                        src="{{ asset('images/work/evasstad-mobile-192.webp') }}"
                        srcset="{{ asset('images/work/evasstad-mobile-192.webp') }} 192w, {{ asset('images/work/evasstad-mobile.webp') }} 390w"
                        sizes="(min-width: 1280px) 134px, (min-width: 1024px) 12vw, (min-width: 640px) 24vw, calc(27vw - 24px)"
                        alt="" width="390" height="844" decoding="async"
                    >
                </div>
                <div class="hero-price">
                    <div>
                        <p class="text-xs font-medium text-muted">{{ __('site.hero.price_from') }} · {{ __('site.hero.price_note') }}</p>
                        <p class="mt-1 font-serif text-3xl font-medium tracking-tight text-pine sm:text-4xl">{{ __('site.hero.price') }}</p>
                    </div>
                    <a href="#packages" class="flex size-12 items-center justify-center rounded-full border border-line text-pine hover:bg-mist" aria-label="{{ __('site.hero.secondary') }}">
                        <x-icon name="external" />
                    </a>
                </div>
            </aside>
            <ul class="grid gap-4 border-t border-line pt-6 text-sm leading-6 text-muted md:grid-cols-3 lg:col-span-2">
                @foreach (__('site.hero.facts') as $fact)
                    <li class="flex items-start gap-3">
                        <x-icon name="check" class="mt-0.5 size-4 text-pine" />
                        <span>{{ $fact }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="border-y border-line bg-mist/60" aria-label="{{ __('site.audience.label') }}">
        <div class="site-container grid gap-6 py-7 lg:grid-cols-[1fr_1.1fr] lg:items-center lg:gap-16">
            <p class="text-sm leading-6 text-muted">{{ __('site.audience.text') }}</p>
            <ul class="flex flex-wrap gap-2">
                @foreach (__('site.audience.trades') as $trade)
                    <li class="inline-flex items-center gap-2 rounded-full border border-pine/15 bg-card/60 px-3.5 py-2 text-xs font-medium text-pine"><x-icon :name="['building', 'sparkles', 'scissors', 'tools', 'truck', 'shop'][$loop->index]" class="size-4" />{{ $trade }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    <section id="examples" class="scroll-mt-24 bg-card py-16 lg:py-24">
        <div class="site-container">
            <div class="grid gap-5 lg:grid-cols-2 lg:items-end lg:gap-16">
                <div>
                    <p class="eyebrow mb-5 text-pine">{{ __('site.nav.examples') }}</p>
                    <h2 class="section-title">{{ __('site.examples.title') }}</h2>
                </div>
                <p class="max-w-xl text-base leading-7 text-muted">{{ __('site.examples.intro') }}</p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                @foreach ([
                    'evasstad' => ['url' => 'https://evasstad.se', 'image' => 'images/work/evasstad.jpg'],
                    'wisegent' => ['url' => 'https://wisegent.se/se', 'image' => 'images/work/wisegent.jpg'],
                ] as $key => $site)
                    <a href="{{ $site['url'] }}" target="_blank" rel="noopener noreferrer" class="work-card group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-line bg-card">
                        <div @class(['work-preview', 'bg-[#ede9df]' => $key === 'wisegent'])>
                            <div class="project-window">
                                <div class="window-toolbar" aria-hidden="true">
                                    <i></i><i></i><i></i><span>{{ parse_url($site['url'], PHP_URL_HOST) }}</span>
                                </div>
                                <picture>
                                    <source
                                        type="image/webp"
                                        srcset="{{ asset("images/work/$key-640.webp") }} 640w, {{ asset("images/work/$key-960.webp") }} 960w"
                                        sizes="(min-width: 1280px) 530px, (min-width: 768px) 42vw, calc(100vw - 80px)"
                                    >
                                    <img src="{{ asset($site['image']) }}" alt="{{ __("site.examples.work.$key.image_alt") }}" width="1600" height="1000" loading="lazy" decoding="async" class="aspect-[16/10] w-full object-cover object-top">
                                </picture>
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col gap-3 p-5 sm:p-7">
                            <p class="eyebrow text-xs text-clay">{{ __("site.examples.work.$key.kicker") }}</p>
                            <h3 class="font-serif text-2xl leading-tight tracking-tight sm:text-3xl">{{ __("site.examples.work.$key.title") }}</h3>
                            <p class="text-sm leading-6 text-muted">{{ __("site.examples.work.$key.text") }}</p>
                            <div class="mt-auto flex items-center justify-between gap-4 pt-4">
                                <span class="text-sm font-semibold text-pine">
                                    {{ __("site.examples.work.$key.open") }}
                                    <span class="sr-only"> ({{ __('site.examples.new_tab') }})</span>
                                </span>
                                <span class="work-arrow flex size-11 shrink-0 items-center justify-center rounded-full border border-line text-pine"><x-icon name="external" /></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12 border-t border-line pt-9">
                <h3 class="font-serif text-2xl tracking-tight sm:text-3xl">{{ __('site.examples.secondary_title') }}</h3>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">{{ __('site.examples.secondary_intro') }}</p>
                <div class="mt-6 grid gap-4 lg:grid-cols-2">
                    @foreach ([
                        'cleaning' => ['route' => 'example.cleaning', 'image' => 'images/examples/cleaning-hero.jpg'],
                        'painting' => ['route' => 'example.painting', 'image' => 'images/examples/painting-hero.jpg'],
                    ] as $key => $example)
                        <a href="{{ \App\Support\Locales::urlFor($example['route'], app()->getLocale()) }}" class="work-card grid min-w-0 overflow-hidden rounded-2xl border border-line sm:grid-cols-[0.8fr_1fr]">
                            <picture class="block">
                                <source srcset="{{ asset("images/examples/$key-preview.webp") }}" type="image/webp">
                                <img src="{{ asset($example['image']) }}" alt="{{ __("site.examples.preview_$key") }}" width="1600" height="1067" loading="lazy" decoding="async" class="aspect-[16/7] h-full w-full object-cover sm:aspect-square">
                            </picture>
                            <div class="flex flex-col justify-center gap-3 p-5 sm:p-6">
                                <p class="text-xs font-medium text-clay">{{ __("site.examples.$key.kicker") }}</p>
                                <h4 class="font-serif text-lg leading-snug sm:text-xl">{{ __("site.examples.$key.title") }}</h4>
                                <span class="inline-flex items-center gap-2 text-xs font-semibold text-pine">{{ __('site.examples.open') }} <x-icon class="size-4" /></span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="why" class="site-container scroll-mt-24 py-16 lg:py-20">
        <div class="grid items-end gap-5 lg:grid-cols-[1fr_0.8fr] lg:gap-20">
            <h2 class="section-title">{{ __('site.why.title') }}</h2>
            <p class="max-w-lg text-base leading-7 text-muted">{{ __('site.why.intro') }}</p>
        </div>
        <div class="mt-10 grid gap-5 md:grid-cols-3">
            @foreach (__('site.why.items') as $item)
                <article class="overflow-hidden rounded-2xl border border-line bg-card">
                    <div class="px-5 pt-4"><x-illustration :name="$item['illustration']" /></div>
                    <div class="px-6 pt-2 pb-7 sm:px-7">
                        <h3 class="font-serif text-2xl leading-tight tracking-tight">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-6 text-muted">{{ $item['text'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
        <ul class="mt-8 flex flex-wrap justify-center gap-x-8 gap-y-4 text-sm font-medium text-pine">
            @foreach (__('site.why.promises') as $promise)
                <li class="flex items-center gap-3"><span class="promise-icon"><x-icon :name="['languages', 'pin', 'key'][$loop->index]" /></span>{{ $promise }}</li>
            @endforeach
        </ul>
    </section>

    <section id="packages" class="scroll-mt-24 border-y border-line py-16 lg:py-24">
        <div class="site-container">
            <p class="eyebrow mb-5 text-pine">{{ __('site.nav.packages') }}</p>
            <div class="grid gap-5 lg:grid-cols-2 lg:items-end lg:gap-16">
                <h2 class="section-title">{{ __('site.packages.title') }}</h2>
                <p class="max-w-lg text-base leading-7 text-muted">{{ __('site.packages.intro') }}</p>
            </div>

            <div class="mt-10 grid gap-5 lg:grid-cols-3">
                @foreach (['start', 'firma', 'individual'] as $key)
                    <article @class([
                        'flex min-w-0 flex-col gap-6 rounded-2xl border p-6 sm:p-8',
                        'border-pine bg-pine text-paper' => $key === 'firma',
                        'border-line bg-card' => $key !== 'firma',
                    ])>
                        <div class="flex items-center justify-between">
                            <h3 class="font-serif text-3xl tracking-tight">{{ __("site.packages.names.$key") }}</h3>
                            <span @class(['flex size-11 items-center justify-center rounded-xl', 'bg-paper/10 text-mist' => $key === 'firma', 'bg-mist text-pine' => $key !== 'firma'])><x-icon :name="['start' => 'website', 'firma' => 'layers', 'individual' => 'pen'][$key]" class="size-6" /></span>
                        </div>
                        <div class="border-y border-current/15 py-6">
                            <p class="font-serif text-4xl leading-tight tracking-tight">{{ __("site.packages.$key.price") }}</p>
                            <p @class(['mt-2 text-xs', 'text-mist' => $key === 'firma', 'text-muted' => $key !== 'firma'])>{{ __("site.packages.$key.cadence") }}</p>
                        </div>
                        <p @class(['text-sm leading-6', 'text-mist' => $key === 'firma', 'text-muted' => $key !== 'firma'])>{{ __("site.packages.$key.fit") }}</p>
                        <ul class="flex flex-col gap-3 text-sm leading-6">
                            @foreach (__("site.packages.$key.points") as $point)
                                <li class="flex items-start gap-3"><x-icon name="check" class="mt-1 size-4" /><span>{{ $point }}</span></li>
                            @endforeach
                        </ul>
                        <a href="{{ \App\Support\Locales::quoteUrl($key) }}" @class([
                            'site-button mt-auto w-full justify-between',
                            'bg-paper text-pine hover:bg-mist' => $key === 'firma',
                            'border border-line text-pine hover:bg-mist' => $key !== 'firma',
                        ])>{{ __('site.packages.choose') }}<x-icon /></a>
                    </article>
                @endforeach
            </div>

            <article class="mt-5 grid gap-6 rounded-2xl border border-line bg-mist/60 p-6 sm:p-8 lg:grid-cols-[15rem_1fr_auto] lg:items-center">
                <div>
                    <h3 class="font-serif text-2xl tracking-tight">{{ __('site.packages.names.opieka') }}</h3>
                    <p class="mt-3 font-serif text-3xl tracking-tight">{{ __('site.packages.opieka.price') }}</p>
                    <p class="mt-1 text-xs text-muted">{{ __('site.packages.opieka.cadence') }}</p>
                </div>
                <div>
                    <p class="text-sm leading-6 text-muted">{{ __('site.packages.opieka.fit') }}</p>
                    <ul class="mt-4 flex flex-col gap-2 text-sm leading-6 text-muted">
                        @foreach (__('site.packages.opieka.points') as $point)
                            <li class="flex items-start gap-2"><x-icon name="check" class="mt-1 size-4 text-pine" /><span>{{ $point }}</span></li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ \App\Support\Locales::quoteUrl('opieka') }}" class="site-button w-fit bg-pine text-paper hover:bg-pine-deep">{{ __('site.packages.choose') }}<x-icon /></a>
            </article>
            <p class="mt-6 max-w-3xl text-xs leading-6 text-muted">{{ __('site.packages.domain') }}</p>
        </div>
    </section>

    <section id="process" class="scroll-mt-24 bg-card py-16 lg:py-24">
        <div class="site-container">
            <div>
                <p class="eyebrow mb-5 text-pine">{{ __('site.nav.process') }}</p>
                <h2 class="section-title">{{ __('site.process.title') }}</h2>
                <p class="mt-5 max-w-lg text-base leading-7 text-muted">{{ __('site.process.intro') }}</p>
                <ol class="mt-10 grid gap-8 lg:grid-cols-3 lg:gap-12">
                    @foreach (__('site.process.steps') as $step)
                        <li class="relative">
                            <div class="mb-5 flex items-center gap-4">
                                <span class="flex size-16 shrink-0 items-center justify-center rounded-2xl bg-mist text-pine"><x-icon :name="['chat', 'pen', 'send'][$loop->index]" class="size-7" /></span>
                                <span aria-hidden="true" class="font-serif text-3xl text-clay">0{{ $loop->iteration }}</span>
                                @unless ($loop->last)
                                    <span class="ml-2 hidden flex-1 border-t border-dashed border-line lg:block" aria-hidden="true"></span>
                                @endunless
                            </div>
                            <h3 class="font-serif text-2xl tracking-tight">{{ $step['title'] }}</h3>
                            <p class="mt-3 max-w-md text-sm leading-6 text-muted">{{ $step['text'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
            <details class="faq-item mt-10 rounded-2xl border border-line bg-paper px-6 sm:px-8">
                <summary class="flex cursor-pointer items-center justify-between gap-6 py-5 font-semibold"><span>{{ __('site.provide.title') }}</span><span class="faq-symbol" aria-hidden="true"></span></summary>
                <p class="text-sm leading-6 text-muted">{{ __('site.provide.intro') }}</p>
                <ul class="grid gap-4 py-6 text-sm leading-6 sm:grid-cols-2">
                    @foreach (__('site.provide.items') as $item)
                        <li class="flex items-start gap-3"><x-icon name="check" class="mt-1 size-4 text-pine" /><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
            </details>
        </div>
    </section>

    <section id="faq" class="scroll-mt-24 border-t border-line bg-card py-16 lg:py-24">
        <div class="site-container grid gap-8 lg:grid-cols-[0.7fr_1.3fr] lg:gap-20">
            <div>
                <p class="eyebrow mb-5 text-pine">{{ __('site.nav.faq') }}</p>
                <h2 class="section-title">{{ __('site.faq.title') }}</h2>
            </div>
            <div class="divide-y divide-line border-y border-line">
                @foreach (__('site.faq.items') as $item)
                    <details class="faq-item">
                        <summary class="flex cursor-pointer items-center justify-between gap-6 py-5 text-sm font-semibold sm:text-base">
                            <span>{{ $item['q'] }}</span>
                            <span class="faq-symbol" aria-hidden="true"></span>
                        </summary>
                        <p class="pr-8 pb-6 text-sm leading-7 text-muted">{{ $item['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-card pb-16 lg:pb-24">
        <div class="site-container relative isolate flex flex-col items-start justify-between gap-8 overflow-hidden rounded-2xl bg-pine p-7 text-paper sm:p-12 lg:flex-row lg:items-center lg:p-16">
            <svg class="closing-art -z-10" viewBox="0 0 200 200" fill="none" aria-hidden="true"><path d="M100 4c8 64 32 88 96 96-64 8-88 32-96 96-8-64-32-88-96-96C68 92 92 68 100 4Z" stroke="currentColor" stroke-width="2" /><circle cx="100" cy="100" r="62" stroke="currentColor" stroke-width="2" /></svg>
            <div class="max-w-2xl">
                <h2 class="section-title">{{ __('site.closing.title') }}</h2>
                <p class="mt-5 max-w-lg text-base leading-7 text-mist">{{ __('site.closing.text') }}</p>
            </div>
            <a href="{{ \App\Support\Locales::urlFor('contact', app()->getLocale()) }}" class="site-button shrink-0 bg-paper text-pine hover:bg-mist">{{ __('site.closing.button') }}<x-icon /></a>
        </div>
    </section>
</x-layouts.site>
