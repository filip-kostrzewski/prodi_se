<x-layouts.example :title="$title" :description="$description" theme="cleaning" quote-package="start">
    <x-slot:header>
        <header class="border-b border-ex-line bg-ex-card/95 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-3">
                <a href="#content" class="font-serif text-2xl leading-none">{{ __('site.cleaning_site.name') }}</a>
                <a href="{{ __('site.examples.demo.phone_href') }}" class="inline-flex rounded-full bg-ex-accent px-4 py-2 text-sm font-semibold text-white">
                    {{ __('site.examples.demo.call') }} {{ __('site.examples.demo.phone_display') }}
                </a>
            </div>
            <nav aria-label="{{ __('site.a11y.primary') }}" class="mx-auto grid max-w-6xl grid-cols-4 text-center text-sm font-semibold">
                @foreach (__('site.cleaning_site.nav') as $id => $label)
                    <a href="#{{ $id }}" class="border-t border-ex-line px-2 py-3 text-ex-ink hover:bg-ex-soft">{{ $label }}</a>
                @endforeach
            </nav>
        </header>
    </x-slot:header>

    <section class="relative isolate min-h-[32rem] overflow-hidden">
        <img
            src="{{ asset('images/examples/cleaning-hero.jpg') }}"
            alt="{{ __('site.cleaning_site.hero_alt') }}"
            width="1600"
            height="1067"
            fetchpriority="high"
            class="absolute inset-0 h-full w-full object-cover"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-[#042421]/92 via-[#042421]/78 to-[#042421]/30"></div>
        <div class="relative mx-auto flex min-h-[32rem] max-w-6xl flex-col justify-end px-5 py-12 sm:py-16">
            <p class="text-sm font-semibold tracking-wide text-white/90">{{ __('site.examples.disclaimer') }}</p>
            <h1 class="mt-3 max-w-2xl font-serif text-4xl leading-[1.08] text-balance text-white sm:text-6xl">{{ __('site.cleaning_site.hero') }}</h1>
            <p class="mt-4 max-w-xl text-lg leading-8 text-white">{{ __('site.cleaning_site.lead') }}</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ __('site.examples.demo.phone_href') }}" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3.5 text-base font-semibold text-[#042421]">{{ __('site.examples.demo.call') }} {{ __('site.examples.demo.phone_display') }}</a>
                <a href="{{ \App\Support\Locales::quoteUrl('start') }}" class="inline-flex items-center justify-center rounded-full border border-white/80 px-6 py-3.5 text-base font-semibold text-white">{{ __('site.examples.demo.quote') }}</a>
            </div>
        </div>
    </section>

    <section class="border-b border-ex-line bg-ex-card" aria-label="{{ __('site.examples.demo.stars_label') }}">
        <dl class="mx-auto grid max-w-6xl gap-6 px-5 py-6 sm:grid-cols-3">
            <div>
                <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.hours_label') }}</dt>
                <dd class="mt-1 text-base">{{ __('site.examples.demo.hours') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.area_label') }}</dt>
                <dd class="mt-1 text-base">{{ __('site.cleaning_site.area') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-semibold text-ex-accent">{{ __('site.examples.demo.stars_label') }}</dt>
                <dd class="mt-1 text-base">
                    <span aria-hidden="true" class="tracking-tight text-ex-accent">★★★★★</span>
                    <span class="mt-1 block text-sm leading-6 text-ex-muted">{{ __('site.examples.demo.stars_note') }}</span>
                </dd>
            </div>
        </dl>
    </section>

    <section id="services" class="scroll-mt-40 mx-auto max-w-6xl px-5 py-16">
        <div class="max-w-2xl">
            <h2 class="font-serif text-4xl">{{ __('site.cleaning_site.services_title') }}</h2>
            <p class="mt-3 text-lg leading-8 text-ex-muted">{{ __('site.cleaning_site.services_intro') }}</p>
        </div>
        <div class="mt-8 grid gap-4 sm:grid-cols-2">
            @foreach (__('site.cleaning_site.services') as $service)
                <article class="rounded-3xl bg-ex-card p-6 ring-1 ring-ex-line">
                    <span class="flex size-12 items-center justify-center rounded-2xl bg-ex-soft text-ex-accent">
                        <x-examples.icon :name="$service['icon']" />
                    </span>
                    <h3 class="mt-4 font-serif text-2xl">{{ $service['title'] }}</h3>
                    <p class="mt-2 text-base leading-7 text-ex-muted">{{ $service['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl items-center gap-8 px-5 pb-16 lg:grid-cols-2">
        <img
            src="{{ asset('images/examples/cleaning-work.jpg') }}"
            alt="{{ __('site.cleaning_site.work_alt') }}"
            width="1200"
            height="900"
            loading="lazy"
            class="aspect-[4/3] w-full rounded-[2rem] object-cover"
        >
        <div>
            <h2 class="font-serif text-4xl">{{ __('site.cleaning_site.visit_title') }}</h2>
            <p class="mt-4 text-lg leading-8 text-ex-muted">{{ __('site.cleaning_site.visit') }}</p>
            <img
                src="{{ asset('images/examples/cleaning-result.jpg') }}"
                alt="{{ __('site.cleaning_site.result_alt') }}"
                width="1400"
                height="933"
                loading="lazy"
                class="mt-6 aspect-[16/9] w-full rounded-3xl object-cover"
            >
        </div>
    </section>

    <section id="area" class="scroll-mt-40 border-y border-ex-line bg-ex-card">
        <div class="mx-auto max-w-6xl px-5 py-16">
            <h2 class="font-serif text-4xl">{{ __('site.cleaning_site.area_title') }}</h2>
            <p class="mt-3 max-w-2xl text-lg leading-8 text-ex-muted">{{ __('site.cleaning_site.area') }}</p>
            <ul class="mt-6 flex flex-wrap gap-2">
                @foreach (__('site.cleaning_site.places') as $place)
                    <li class="rounded-full bg-ex-soft px-4 py-2 text-base font-semibold">{{ $place }}</li>
                @endforeach
            </ul>
            <p class="mt-4 text-sm leading-6 text-ex-muted">{{ __('site.cleaning_site.area_note') }}</p>
        </div>
    </section>

    <section id="reviews" class="scroll-mt-40 mx-auto max-w-6xl px-5 py-16">
        <h2 class="font-serif text-4xl">{{ __('site.examples.demo.stars_label') }}</h2>
        <div class="mt-6 max-w-xl rounded-3xl bg-ex-card p-6 ring-1 ring-ex-line">
            <p aria-hidden="true" class="text-2xl tracking-tight text-ex-accent">★★★★★</p>
            <p class="mt-3 text-base leading-7">{{ __('site.examples.demo.stars_note') }}</p>
        </div>
    </section>

    <section id="contact" class="scroll-mt-40 mx-auto grid max-w-6xl gap-8 px-5 pb-16 lg:grid-cols-[1.1fr_0.9fr]">
        <div>
            <h2 class="font-serif text-4xl">{{ __('site.cleaning_site.contact_title') }}</h2>
            <p class="mt-3 text-lg leading-8 text-ex-muted">{{ __('site.cleaning_site.contact_lead') }}</p>
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
        </div>
        <aside class="rounded-[2rem] bg-ex-accent p-6 text-white sm:p-8">
            <h3 class="font-serif text-3xl">{{ __('site.examples.demo.quote') }}</h3>
            <p class="mt-3 text-base leading-7 text-white/90">{{ __('site.examples.disclaimer') }}</p>
            <a href="{{ \App\Support\Locales::quoteUrl('start') }}" class="mt-6 inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-ex-ink">{{ __('site.examples.demo.quote') }}</a>
        </aside>
    </section>
</x-layouts.example>
