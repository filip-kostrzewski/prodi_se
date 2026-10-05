<x-layouts.site :title="$title" :description="$description">
    @php
        $orgNumber = \App\Support\Company::orgNumber();
        $streetLine = \App\Support\Company::streetLine();
    @endphp
    <article class="mx-auto max-w-3xl px-5 py-14 lg:py-20">
        <h1 class="font-serif text-4xl text-balance sm:text-5xl">{{ __('site.privacy.title') }}</h1>
        <p class="mt-4 text-lg leading-8 text-muted">{{ __('site.privacy.lead') }}</p>
        <div class="mt-10 flex flex-col gap-8">
            @foreach (__('site.privacy.sections') as $section)
                <section>
                    <h2 class="font-serif text-2xl">{{ $section['title'] }}</h2>
                    <p class="mt-2 text-sm leading-6 text-muted">{{ $section['text'] }}</p>
                </section>
            @endforeach
            <section>
                <h2 class="font-serif text-2xl">{{ __('site.privacy.company_title') }}</h2>
                <div class="mt-2 flex flex-col gap-2 text-sm leading-6 text-muted">
                    @if ($orgNumber)
                        <p>{{ __('site.privacy.org_line', ['number' => $orgNumber, 'city' => \App\Support\Company::city()]) }}</p>
                    @endif
                    @if ($streetLine)
                        <p>{{ $streetLine }}, {{ \App\Support\Company::city() }}</p>
                    @endif
                </div>
            </section>
        </div>
    </article>
</x-layouts.site>
