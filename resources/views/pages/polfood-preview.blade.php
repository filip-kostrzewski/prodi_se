<x-layouts.site :title="$title" :description="$description" :noindex="true">
    <section class="site-container py-14 lg:py-20">
        <h1 class="section-title">Polfood — projekt wizytówki</h1>
        <p class="mt-6 max-w-2xl text-lg leading-8 text-muted">Wizytówka dwustronna, 85 × 55 mm. Przód kremowy z pieczęcią „Anno 1984”, tył burgundowy.</p>

        <a href="{{ asset('images/presentations/polfood/mockup-full.jpg') }}" class="mt-10 block overflow-hidden rounded-2xl border border-line bg-card">
            <img
                src="{{ asset('images/presentations/polfood/mockup.webp') }}"
                alt="Makieta wizytówek Polfood na jasnym drewnianym blacie: stos burgundowych rewersów z napisem „smacznego!” i kremowy awers z pieczęcią „Anno 1984”."
                width="1600"
                height="1067"
                decoding="async"
                class="w-full"
            >
            <span class="sr-only">Otwórz w pełnej rozdzielczości.</span>
        </a>

        <a href="{{ asset('images/presentations/polfood/flat-full.jpg') }}" class="mt-8 block overflow-hidden rounded-2xl border border-line bg-card">
            <img
                src="{{ asset('images/presentations/polfood/flat.webp') }}"
                alt="Płaski podgląd wizytówki Polfood, 85 × 55 mm: kremowy przód z logo Polfood i pieczęcią „Anno 1984” oraz burgundowy tył z danymi kontaktowymi."
                width="1600"
                height="837"
                loading="lazy"
                decoding="async"
                class="w-full"
            >
            <span class="sr-only">Otwórz w pełnej rozdzielczości.</span>
        </a>
    </section>
</x-layouts.site>
