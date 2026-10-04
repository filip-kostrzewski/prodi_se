<x-layouts.example :title="$title" :description="$description" theme="cleaning">
    <header class="mx-auto flex max-w-5xl flex-col gap-2 px-5 py-8 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold tracking-[0.16em] text-ex-accent uppercase">{{ __('site.examples.disclaimer') }}</p>
            <p class="mt-2 font-serif text-3xl">{{ __('site.cleaning_site.name') }}</p>
        </div>
        <p class="text-sm text-ex-ink/70">{{ __('site.cleaning_site.tagline') }}</p>
    </header>

    <section class="mx-auto max-w-5xl px-5 pb-12">
        <div class="rounded-[2rem] bg-ex-accent px-6 py-10 text-white sm:px-10">
            <h1 class="max-w-xl font-serif text-4xl leading-tight text-balance sm:text-5xl">{{ __('site.cleaning_site.hero') }}</h1>
            <p class="mt-4 max-w-xl text-sm leading-6 text-white/85">{{ __('site.cleaning_site.lead') }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-5 pb-12" aria-labelledby="cleaning-services">
        <h2 id="cleaning-services" class="font-serif text-3xl">{{ __('site.cleaning_site.services_title') }}</h2>
        <div class="mt-6 grid gap-3 sm:grid-cols-2">
            @foreach (__('site.cleaning_site.services') as $service)
                <article class="rounded-3xl border border-ex-line bg-ex-card p-5">
                    <h3 class="font-semibold">{{ $service['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-ex-ink/75">{{ $service['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto grid max-w-5xl gap-4 px-5 pb-16 md:grid-cols-2">
        <article class="rounded-3xl border border-ex-line bg-ex-card p-6">
            <h2 class="font-serif text-2xl">{{ __('site.cleaning_site.area_title') }}</h2>
            <p class="mt-3 text-sm leading-6 text-ex-ink/75">{{ __('site.cleaning_site.area') }}</p>
        </article>
        <article class="rounded-3xl border border-ex-line bg-ex-card p-6">
            <h2 class="font-serif text-2xl">{{ __('site.cleaning_site.contact_title') }}</h2>
            <p class="mt-3 text-sm leading-6 text-ex-ink/75">{{ __('site.examples.contact_note') }}</p>
        </article>
    </section>
</x-layouts.example>
