<?php

$list = fn (string $key): array => array_values(array_filter(array_map(
    fn (string $value): string => strtolower(trim($value)),
    explode(',', (string) env($key, '')),
)));

return [

    /*
    |--------------------------------------------------------------------------
    | Blocked senders
    |--------------------------------------------------------------------------
    |
    | Quote requests from these e-mail addresses or client IPs are saved as
    | spam and never e-mailed. Extend without a deploy through comma lists
    | in CONTACT_BLOCKED_EMAILS and CONTACT_BLOCKED_IPS.
    |
    */

    'blocked_emails' => array_values(array_unique([
        'edwardsmith076459@gmail.com', // "Edward Smith", Webexpert, SEO + AEO pitch, 2026-10-11
        ...$list('CONTACT_BLOCKED_EMAILS'),
    ])),

    'blocked_ips' => array_values(array_unique([
        ...$list('CONTACT_BLOCKED_IPS'),
    ])),

    /*
    | Submissions sent faster than this after the form was rendered are
    | treated as bots: they get the normal thank-you and nothing else.
    |
    */

    'min_fill_seconds' => (int) env('CONTACT_MIN_FILL_SECONDS', 3),

    /*
    |--------------------------------------------------------------------------
    | Cloudflare Turnstile
    |--------------------------------------------------------------------------
    |
    | Active only when both keys are set. Without them no widget is shown
    | and no check runs.
    |
    */

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
        'timeout' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | AI spam check (Laravel AI SDK, yes / no decision)
    |--------------------------------------------------------------------------
    |
    | Runs only when the provider has an API key (TYPESAFE_API_KEY for the
    | default "typesafe" provider). Any error or timeout lets the inquiry
    | through, so a real request is never lost. The inquiry is held back
    | only when the probability that it is genuine is below the threshold.
    |
    */

    'ai' => [
        'enabled' => (bool) env('CONTACT_AI_ENABLED', true),
        'provider' => env('CONTACT_AI_PROVIDER', 'typesafe'),
        'model' => env('CONTACT_AI_MODEL') ?: null,
        'timeout' => (int) env('CONTACT_AI_TIMEOUT', 10),
        'threshold' => (float) env('CONTACT_AI_THRESHOLD', 0.3),
    ],

];
