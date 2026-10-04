<x-layouts.site :title="$title" :description="$description">
    <div class="mx-auto grid max-w-6xl gap-12 px-5 py-14 lg:grid-cols-[0.8fr_1.2fr] lg:py-20">
        <div>
            <h1 class="font-serif text-4xl text-balance sm:text-5xl">{{ __('site.contact.title') }}</h1>
            <p class="mt-4 text-lg leading-8 text-muted">{{ __('site.contact.lead') }}</p>
            <p class="mt-6 text-sm leading-6 text-muted">{{ __('site.contact.aside') }}</p>
        </div>

        <form method="POST" action="{{ \App\Support\Locales::urlFor('contact', app()->getLocale()) }}" class="relative flex flex-col gap-5 rounded-3xl border border-line bg-card p-6 sm:p-8" novalidate>
            @csrf

            <div class="absolute -left-[9999px] h-px w-px overflow-hidden" aria-hidden="true">
                <label for="website_url">Website</label>
                <input id="website_url" name="website_url" type="text" tabindex="-1" autocomplete="off" value="">
            </div>

            @if (session('status'))
                <p role="status" class="rounded-2xl bg-mist px-4 py-3 text-sm">{{ session('status') }}</p>
            @endif

            @if ($errors->any())
                <div role="alert" class="rounded-2xl border border-clay/30 bg-paper px-4 py-3 text-sm text-clay">
                    <ul class="flex flex-col gap-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-sm font-semibold">{{ __('site.form.name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required maxlength="120" class="rounded-xl border border-line bg-paper px-3 py-3">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="company" class="text-sm font-semibold">{{ __('site.form.company') }} <span class="font-normal text-muted">({{ __('site.form.optional') }})</span></label>
                    <input id="company" name="company" type="text" value="{{ old('company') }}" autocomplete="organization" maxlength="160" class="rounded-xl border border-line bg-paper px-3 py-3">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm font-semibold">{{ __('site.form.email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required maxlength="160" class="rounded-xl border border-line bg-paper px-3 py-3">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="phone" class="text-sm font-semibold">{{ __('site.form.phone') }} <span class="font-normal text-muted">({{ __('site.form.optional') }})</span></label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" maxlength="40" class="rounded-xl border border-line bg-paper px-3 py-3">
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="package" class="text-sm font-semibold">{{ __('site.form.package') }}</label>
                <select id="package" name="package" required class="rounded-xl border border-line bg-paper px-3 py-3">
                    <option value="">{{ __('site.form.package_placeholder') }}</option>
                    @foreach (\App\Package::cases() as $package)
                        <option value="{{ $package->value }}" @selected(old('package') === $package->value)>{{ $package->optionLabel() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label for="message" class="text-sm font-semibold">{{ __('site.form.message') }}</label>
                <textarea id="message" name="message" required maxlength="5000" rows="6" class="rounded-xl border border-line bg-paper px-3 py-3" placeholder="{{ __('site.form.message_hint') }}">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-sm font-semibold text-paper hover:bg-pine-deep">
                {{ __('site.form.submit') }}
            </button>

            <p class="text-sm leading-6 text-muted">
                {{ __('site.form.privacy') }}
                <a class="underline decoration-line underline-offset-4" href="{{ \App\Support\Locales::urlFor('privacy', app()->getLocale()) }}">{{ __('site.form.privacy_link') }}</a>
            </p>
        </form>
    </div>
</x-layouts.site>
