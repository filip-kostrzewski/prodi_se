<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use App\Support\ContactFormTimer;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Laravel\Ai\Classification;
use Laravel\Ai\Prompts\ClassificationPrompt;
use Laravel\Ai\Responses\Data\BooleanAnswer;
use RuntimeException;
use Tests\TestCase;

class ContactSpamProtectionTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const THANK_YOU = 'Tack. Vi har tagit emot din förfrågan och återkommer.';

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        config(['prodi.contact_email' => 'owner@example.com']);
    }

    public function test_form_renders_honeypot_and_timer_without_turnstile_by_default(): void
    {
        $this->get(route('sv.contact'))
            ->assertOk()
            ->assertSee('name="website_url"', false)
            ->assertSee('name="form_started"', false)
            ->assertDontSee('cf-turnstile', false);

        $this->get(route('pl.contact'))
            ->assertOk()
            ->assertSee('name="website_url"', false);
    }

    public function test_honeypot_is_dropped_silently(): void
    {
        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload(['website_url' => 'https://spam.test']))
            ->assertRedirect(route('sv.contact'))
            ->assertSessionHas('status', self::THANK_YOU);

        $this->assertSame(0, ContactInquiry::query()->count());
        Mail::assertNothingSent();
    }

    public function test_submission_faster_than_the_minimum_is_dropped_silently(): void
    {
        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload([
                ContactFormTimer::FIELD => ContactFormTimer::issue(),
            ]))
            ->assertRedirect(route('sv.contact'))
            ->assertSessionHas('status', self::THANK_YOU);

        $this->assertSame(0, ContactInquiry::query()->count());
        Mail::assertNothingSent();
    }

    public function test_submission_after_the_minimum_time_is_emailed(): void
    {
        $token = ContactFormTimer::issue();
        $this->travel(8)->seconds();

        $this->post(route('sv.contact.store'), $this->payload([ContactFormTimer::FIELD => $token]))
            ->assertSessionHas('status', self::THANK_YOU);

        Mail::assertSent(ContactInquiryReceived::class, 1);
        $this->assertNull(ContactInquiry::query()->first()->spam_reason);
    }

    public function test_tampered_timer_does_not_lose_a_real_inquiry(): void
    {
        $this->post(route('sv.contact.store'), $this->payload([ContactFormTimer::FIELD => 'not-a-token']));

        Mail::assertSent(ContactInquiryReceived::class, 1);
    }

    public function test_blocked_email_is_saved_as_spam_and_not_emailed(): void
    {
        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload([
                'name' => 'Edward Smith',
                'company' => 'Webexpert',
                'email' => 'EdwardSmith076459@Gmail.com',
                'message' => 'We offer a complete SEO + AEO strategy for your website.',
            ]))
            ->assertRedirect(route('sv.contact'))
            ->assertSessionHas('status', self::THANK_YOU);

        $inquiry = ContactInquiry::query()->sole();
        $this->assertSame('blocked_email', $inquiry->spam_reason);
        Mail::assertNothingSent();
    }

    public function test_blocked_ip_is_saved_as_spam_and_not_emailed(): void
    {
        config(['contact.blocked_ips' => ['203.0.113.9']]);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.9'])
            ->post(route('sv.contact.store'), $this->payload())
            ->assertSessionHas('status', self::THANK_YOU);

        $inquiry = ContactInquiry::query()->sole();
        $this->assertSame('blocked_ip', $inquiry->spam_reason);
        $this->assertSame('203.0.113.9', $inquiry->ip_address);
        Mail::assertNothingSent();
    }

    public function test_rate_limit_refuses_the_sixth_submission(): void
    {
        foreach (range(1, 5) as $attempt) {
            $this->post(route('sv.contact.store'), $this->payload(['email' => "anna{$attempt}@example.com"]));
        }

        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload(['email' => 'anna6@example.com']))
            ->assertSessionHasErrors('form');

        Mail::assertSent(ContactInquiryReceived::class, 5);
    }

    public function test_ai_no_saves_as_spam_and_sends_nothing(): void
    {
        config(['ai.providers.typesafe.key' => 'test-key']);
        Classification::fake([['decision' => new BooleanAnswer(0.04)]]);

        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload([
                'message' => 'Hi, we can boost your Google ranking with our SEO + AEO strategy.',
            ]))
            ->assertSessionHas('status', self::THANK_YOU);

        $this->assertSame('ai_not_genuine', ContactInquiry::query()->sole()->spam_reason);
        Mail::assertNothingSent();
        Classification::assertClassified(fn (ClassificationPrompt $prompt) => str_contains(json_encode($prompt->state), 'SEO + AEO'));
    }

    public function test_ai_yes_sends_the_mail(): void
    {
        config(['ai.providers.typesafe.key' => 'test-key']);
        Classification::fake([['decision' => new BooleanAnswer(0.97)]]);

        $this->post(route('sv.contact.store'), $this->payload());

        $this->assertNull(ContactInquiry::query()->sole()->spam_reason);
        Mail::assertSent(ContactInquiryReceived::class, 1);
    }

    public function test_ai_failure_lets_the_inquiry_through(): void
    {
        config(['ai.providers.typesafe.key' => 'test-key']);
        Classification::fake(fn () => throw new RuntimeException('Provider down'));

        $this->post(route('sv.contact.store'), $this->payload());

        $this->assertNull(ContactInquiry::query()->sole()->spam_reason);
        Mail::assertSent(ContactInquiryReceived::class, 1);
    }

    public function test_without_an_api_key_the_ai_is_skipped_and_mail_is_sent(): void
    {
        config(['ai.providers.typesafe.key' => null]);
        Classification::fake();

        $this->post(route('sv.contact.store'), $this->payload());

        Classification::assertNothingClassified();
        Mail::assertSent(ContactInquiryReceived::class, 1);
    }

    public function test_blocked_sender_never_reaches_the_ai(): void
    {
        config(['ai.providers.typesafe.key' => 'test-key']);
        Classification::fake();

        $this->post(route('sv.contact.store'), $this->payload(['email' => 'edwardsmith076459@gmail.com']));

        Classification::assertNothingClassified();
        Mail::assertNothingSent();
    }

    public function test_turnstile_widget_and_check_only_with_both_keys(): void
    {
        config(['contact.turnstile.site_key' => 'site-key', 'contact.turnstile.secret_key' => 'secret']);

        $this->get(route('sv.contact'))->assertSee('cf-turnstile', false)->assertSee('data-sitekey="site-key"', false);

        Http::fake(['challenges.cloudflare.com/*' => Http::sequence()
            ->push(['success' => false])
            ->push(['success' => true])]);

        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload(['cf-turnstile-response' => 'bad']))
            ->assertSessionHasErrors('form');
        Mail::assertNothingSent();

        $this->post(route('sv.contact.store'), $this->payload(['cf-turnstile-response' => 'good', 'email' => 'anna2@example.com']));
        Mail::assertSent(ContactInquiryReceived::class, 1);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Anna Nowak',
            'company' => 'Nowak Städ',
            'email' => 'anna@example.com',
            'phone' => '0701234567',
            'package' => 'firma',
            'message' => 'Vi behöver en sida på polska och svenska.',
        ], $overrides);
    }
}
