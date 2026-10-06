@php
    $orgNumber = \App\Support\Company::orgNumber();
    $email = \App\Support\Company::publishedContactEmail();
@endphp

<div {{ $attributes->class('flex flex-col gap-1') }}>
    @if ($orgNumber)
        <p>{{ __('site.footer.org_number', ['number' => $orgNumber]) }}</p>
    @endif
    @foreach (\App\Support\Company::addressLines() as $line)
        <p>{{ $line }}</p>
    @endforeach
    @if ($email)
        <p><a class="underline decoration-line underline-offset-4" href="mailto:{{ $email }}">{{ $email }}</a></p>
    @endif
</div>
