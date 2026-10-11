<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ContactSpamGuard
{
    public const TURNSTILE_FIELD = 'cf-turnstile-response';

    /**
     * Too fast to be a person. A missing or foreign timer is let through:
     * the CSRF token already stops blind posts, and a tab opened before a
     * deploy must still reach Filip.
     */
    public function submittedTooFast(Request $request): bool
    {
        $elapsed = ContactFormTimer::elapsedSeconds($request->input(ContactFormTimer::FIELD));

        if ($elapsed === null) {
            Log::channel('contact_spam')->info('Contact form without a valid timer, let through.', [
                'ip' => $request->ip(),
            ]);

            return false;
        }

        return $elapsed < (int) config('contact.min_fill_seconds', 3);
    }

    public static function turnstileEnabled(): bool
    {
        return filled(config('contact.turnstile.site_key')) && filled(config('contact.turnstile.secret_key'));
    }

    /**
     * False only when Cloudflare says the token is bad. If Cloudflare cannot
     * be reached, the visitor is let through.
     */
    public function passesTurnstile(Request $request): bool
    {
        if (! self::turnstileEnabled()) {
            return true;
        }

        $token = (string) $request->input(self::TURNSTILE_FIELD, '');

        if ($token === '') {
            return false;
        }

        try {
            $response = Http::asForm()
                ->timeout((int) config('contact.turnstile.timeout', 5))
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('contact.turnstile.secret_key'),
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ]);
        } catch (Throwable $exception) {
            report($exception);

            return true;
        }

        if (! $response->successful()) {
            return true;
        }

        return (bool) $response->json('success', false);
    }

    /**
     * Reason the sender is on the blocklist, or null.
     */
    public function blockedReason(string $email, ?string $ip): ?string
    {
        if (in_array(strtolower(trim($email)), (array) config('contact.blocked_emails', []), true)) {
            return 'blocked_email';
        }

        if ($ip !== null && in_array(strtolower($ip), (array) config('contact.blocked_ips', []), true)) {
            return 'blocked_ip';
        }

        return null;
    }

    public static function aiEnabled(): bool
    {
        $provider = (string) config('contact.ai.provider');

        return (bool) config('contact.ai.enabled', true)
            && $provider !== ''
            && filled(config("ai.providers.{$provider}.key"));
    }

    /**
     * Ask the AI whether this is a real quote request. Fails open: no key,
     * an error or a timeout all count as genuine.
     *
     * @param  array<string, mixed>  $inquiry
     */
    public function looksGenuine(array $inquiry): bool
    {
        if (! self::aiEnabled()) {
            return true;
        }

        try {
            return $this->askAi($inquiry);
        } catch (Throwable $exception) {
            Log::channel('contact_spam')->warning('AI spam check failed, inquiry let through.', [
                'error' => $exception->getMessage(),
            ]);

            return true;
        }
    }

    /**
     * The raw yes / no decision. Throws on any provider error.
     *
     * @param  array<string, mixed>  $inquiry
     */
    public function askAi(array $inquiry): bool
    {
        return Str::of($this->describe($inquiry))->decide(
            'Is this a genuine inquiry from a potential client who wants Prodi, a small web studio in Märsta, Sweden, to build a website or provide a web or IT service for them?',
            criteria: [
                'true' => 'A business or person asks for a new website, a redesign, hosting or care of their site, or another web or IT service for themselves, or asks for a quote or price. It may be short, informal, misspelled, or in Swedish, Polish or English.',
                'false' => 'The sender is selling something to Prodi: SEO, AEO or GEO, digital marketing, link building, guest posts, lead generation, ads, outsourced development or design. Or it is spam, a scam, a test, gibberish, or contains no request for a service.',
            ],
            threshold: (float) config('contact.ai.threshold', 0.3),
            provider: (string) config('contact.ai.provider'),
            model: config('contact.ai.model'),
            timeout: (int) config('contact.ai.timeout', 10),
        );
    }

    /**
     * @param  array<string, mixed>  $context
     */
    public function log(string $reason, Request $request, array $context = []): void
    {
        Log::channel('contact_spam')->notice('Contact form submission held back: '.$reason, [
            'reason' => $reason,
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            ...$context,
        ]);
    }

    /**
     * @param  array<string, mixed>  $inquiry
     */
    private function describe(array $inquiry): string
    {
        return implode("\n", [
            'Contact form submission on prodi.se',
            'Name: '.($inquiry['name'] ?? ''),
            'Company: '.($inquiry['company'] ?? ''),
            'Email: '.($inquiry['email'] ?? ''),
            'Phone: '.($inquiry['phone'] ?? ''),
            'Chosen package: '.($inquiry['package'] ?? ''),
            'Message:',
            (string) ($inquiry['message'] ?? ''),
        ]);
    }
}
