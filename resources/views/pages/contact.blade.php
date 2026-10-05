<x-layouts.site :title="$title" :description="$description">
    @php
        $selectedPackage = old('package', request()->query('package'));
        $selectedPackage = is_string($selectedPackage) && \App\Package::tryFrom($selectedPackage) !== null
            ? $selectedPackage
            : null;
        $invalid = fn (string $field): bool => $errors->has($field);
        $control = fn (string $field): string => 'rounded-xl border bg-paper px-3 py-3 '.($invalid($field) ? 'border-clay' : 'border-line');
        $phone = \App\Support\Company::phone();
        $email = \App\Support\Company::publishedContactEmail();
    @endphp
    <div class="mx-auto grid max-w-6xl gap-12 px-5 py-14 lg:grid-cols-[0.8fr_1.2fr] lg:py-20">
        <div>
            <h1 class="font-serif text-4xl text-balance sm:text-5xl">{{ __('site.contact.title') }}</h1>
            <p class="mt-4 text-lg leading-8 text-muted">{{ __('site.contact.lead') }}</p>
            <p class="mt-6 text-base leading-7 text-muted">{{ __('site.contact.aside') }}</p>
            @if ($email || $phone)
                <div class="mt-6 flex flex-col gap-2 text-base">
                    @if ($email)
                        <a class="font-semibold underline decoration-line underline-offset-4" href="mailto:{{ $email }}">{{ $email }}</a>
                    @endif
                    @if ($phone)
                        <a class="font-semibold underline decoration-line underline-offset-4" href="{{ \App\Support\Company::phoneHref() }}">{{ $phone }}</a>
                        <a class="font-semibold underline decoration-line underline-offset-4" href="{{ \App\Support\Company::whatsappHref() }}">WhatsApp</a>
                    @endif
                </div>
            @endif
        </div>

        <form id="offert" method="POST" action="{{ \App\Support\Locales::urlFor('contact', app()->getLocale()) }}" class="relative flex scroll-mt-28 flex-col gap-5 rounded-3xl border border-line bg-card p-6 sm:p-8" novalidate>
            @csrf

            <div inert aria-hidden="true" class="pointer-events-none absolute h-px w-px overflow-hidden" style="clip-path: inset(50%)">
                <input id="website_url" name="website_url" type="text" tabindex="-1" autocomplete="off" value="">
            </div>

            @if (session('status'))
                <p role="status" class="rounded-2xl bg-mist px-4 py-3 text-base">{{ session('status') }}</p>
            @endif

            @if ($errors->has('form'))
                <p role="alert" class="rounded-2xl border border-clay/30 bg-paper px-4 py-3 text-base text-clay">{{ $errors->first('form') }}</p>
            @elseif ($errors->any())
                <p role="alert" class="rounded-2xl border border-clay/30 bg-paper px-4 py-3 text-base text-clay">{{ __('site.form.errors.summary') }}</p>
            @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-sm font-semibold">{{ __('site.form.name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required maxlength="120" @class([$control('name')]) @if ($invalid('name')) aria-invalid="true" aria-describedby="name-error" @endif>
                    @error('name')
                        <p id="name-error" class="text-sm text-clay">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="company" class="text-sm font-semibold">{{ __('site.form.company') }} <span class="font-normal text-muted">({{ __('site.form.optional') }})</span></label>
                    <input id="company" name="company" type="text" value="{{ old('company') }}" autocomplete="organization" maxlength="160" @class([$control('company')]) @if ($invalid('company')) aria-invalid="true" aria-describedby="company-error" @endif>
                    @error('company')
                        <p id="company-error" class="text-sm text-clay">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm font-semibold">{{ __('site.form.email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required maxlength="160" @class([$control('email')]) @if ($invalid('email')) aria-invalid="true" aria-describedby="email-error" @endif>
                    @error('email')
                        <p id="email-error" class="text-sm text-clay">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="phone" class="text-sm font-semibold">{{ __('site.form.phone') }} <span class="font-normal text-muted">({{ __('site.form.optional') }})</span></label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" maxlength="40" @class([$control('phone')]) @if ($invalid('phone')) aria-invalid="true" aria-describedby="phone-error" @endif>
                    @error('phone')
                        <p id="phone-error" class="text-sm text-clay">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="package" class="text-sm font-semibold">{{ __('site.form.package') }}</label>
                <select id="package" name="package" required @class([$control('package')]) @if ($invalid('package')) aria-invalid="true" aria-describedby="package-error" @endif>
                    <option value="">{{ __('site.form.package_placeholder') }}</option>
                    @foreach (\App\Package::cases() as $package)
                        <option value="{{ $package->value }}" @selected($selectedPackage === $package->value)>{{ $package->optionLabel() }}</option>
                    @endforeach
                </select>
                @error('package')
                    <p id="package-error" class="text-sm text-clay">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-2">
                <label for="message" class="text-sm font-semibold">{{ __('site.form.message') }}</label>
                <textarea id="message" name="message" required maxlength="5000" rows="6" placeholder="{{ __('site.form.message_hint') }}" @class([$control('message')]) @if ($invalid('message')) aria-invalid="true" aria-describedby="message-error" @endif>{{ old('message') }}</textarea>
                @error('message')
                    <p id="message-error" class="text-sm text-clay">{{ $message }}</p>
                @enderror
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
