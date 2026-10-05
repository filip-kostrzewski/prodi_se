<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ContactInquiryControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * @return array<string, array{0: string, 1: string, 2: string}>
     */
    public static function acceptedLocales(): array
    {
        return [
            'swedish' => ['sv.contact.store', 'sv', 'Tack. Vi har tagit emot din förfrågan och återkommer.'],
            'polish' => ['pl.contact.store', 'pl', 'Dziękuję. Dostałem zapytanie i odezwę się.'],
        ];
    }

    #[DataProvider('acceptedLocales')]
    public function test_valid_inquiry_is_stored_and_emailed(string $route, string $locale, string $status): void
    {
        Mail::fake();
        config(['prodi.contact_email' => 'owner@example.com']);

        $response = $this->from(route(str_replace('.store', '', $route)))
            ->post(route($route), $this->payload());

        $response->assertRedirect(route(str_replace('.store', '', $route)));
        $response->assertSessionHas('status', $status);

        $inquiry = ContactInquiry::query()->first();

        $this->assertNotNull($inquiry);
        $this->assertSame('Anna Nowak', $inquiry->name);
        $this->assertSame('anna@example.com', $inquiry->email);
        $this->assertSame('firma', $inquiry->package->value);
        $this->assertSame($locale, $inquiry->locale);

        Mail::assertSent(ContactInquiryReceived::class, function (ContactInquiryReceived $mail) use ($inquiry): bool {
            return $mail->hasTo('owner@example.com')
                && $mail->hasReplyTo('anna@example.com')
                && $mail->inquiry->is($inquiry);
        });
    }

    public function test_inquiry_without_company_or_phone_is_stored(): void
    {
        Mail::fake();
        config(['prodi.contact_email' => 'owner@example.com']);

        $this->post(route('sv.contact.store'), $this->payload([
            'company' => '',
            'phone' => '',
        ]))->assertRedirect();

        $inquiry = ContactInquiry::query()->first();

        $this->assertNotNull($inquiry);
        $this->assertNull($inquiry->company);
        $this->assertNull($inquiry->phone);
    }

    public function test_empty_submission_shows_swedish_validation_messages(): void
    {
        $response = $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), []);

        $response->assertRedirect(route('sv.contact'));
        $response->assertSessionHasErrors([
            'name' => 'Fyll i ditt namn.',
            'email' => 'Fyll i en e-postadress.',
            'package' => 'Välj ett paket.',
            'message' => 'Skriv ett kort meddelande.',
        ]);
        $this->assertSame(0, ContactInquiry::query()->count());

        $this->followingRedirects()
            ->from(route('sv.contact'))
            ->post(route('sv.contact.store'), [])
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('id="name-error"', false)
            ->assertSee('Fyll i ditt namn.', false)
            ->assertSee('Rätta de markerade fälten.', false);
    }

    public function test_empty_polish_submission_shows_polish_validation_message(): void
    {
        $this->from(route('pl.contact'))
            ->post(route('pl.contact.store'), [])
            ->assertSessionHasErrors([
                'name' => 'Podaj imię i nazwisko.',
            ]);
    }

    public function test_invalid_email_is_rejected(): void
    {
        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload(['email' => 'inte-en-adress']))
            ->assertSessionHasErrors([
                'email' => 'E-postadressen ser inte giltig ut.',
            ]);
    }

    public function test_unknown_package_is_rejected(): void
    {
        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload(['package' => 'premium']))
            ->assertSessionHasErrors([
                'package' => 'Välj ett av paketen i listan.',
            ]);
    }

    public function test_honeypot_submission_is_not_stored_or_emailed(): void
    {
        Mail::fake();

        $response = $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload([
                'website_url' => 'https://spam.test',
            ]));

        $response->assertRedirect(route('sv.contact'));
        $response->assertSessionHas('status', 'Tack. Vi har tagit emot din förfrågan och återkommer.');
        $this->assertSame(0, ContactInquiry::query()->count());
        Mail::assertNothingSent();
    }

    public function test_sixth_submission_from_the_same_ip_is_refused(): void
    {
        Mail::fake();
        config(['prodi.contact_email' => 'owner@example.com']);

        foreach (range(1, 5) as $attempt) {
            $this->post(route('sv.contact.store'), $this->payload([
                'email' => "anna{$attempt}@example.com",
            ]))->assertRedirect();
        }

        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload([
                'email' => 'anna6@example.com',
            ]))
            ->assertRedirect(route('sv.contact'))
            ->assertSessionHasErrors([
                'form' => 'För många förfrågningar just nu. Vänta en stund och försök igen.',
            ]);

        $this->assertSame(5, ContactInquiry::query()->count());
        Mail::assertSent(ContactInquiryReceived::class, 5);
    }

    public function test_rejected_submission_escapes_the_name_on_the_form(): void
    {
        $response = $this->followingRedirects()
            ->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload([
                'name' => '<script>alert(1)</script>',
                'email' => 'inte-en-adress',
            ]));

        $response->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
        $response->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_a_mail_transport_failure_keeps_the_inquiry_and_shows_an_error(): void
    {
        config([
            'mail.default' => 'postmark',
            'services.postmark.key' => null,
            'prodi.contact_email' => 'filip@prodi.se',
        ]);

        $this->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload())
            ->assertRedirect(route('sv.contact'))
            ->assertSessionHasErrors([
                'form' => 'Förfrågan är sparad, men mejlet gick inte iväg. Skriv till filip@prodi.se så tar vi det därifrån.',
            ]);

        $this->followingRedirects()
            ->from(route('sv.contact'))
            ->post(route('sv.contact.store'), $this->payload(['email' => 'anna2@example.com']))
            ->assertSee('Förfrågan är sparad, men mejlet gick inte iväg. Skriv till filip@prodi.se så tar vi det därifrån.', false)
            ->assertDontSee('Server Error', false);

        $this->from(route('pl.contact'))
            ->post(route('pl.contact.store'), $this->payload(['email' => 'anna3@example.com']))
            ->assertSessionHasErrors([
                'form' => 'Zapytanie jest zapisane, ale mail nie wyszedł. Napisz na filip@prodi.se, to odpiszę.',
            ]);

        $this->assertSame(3, ContactInquiry::query()->count());
    }

    public function test_posted_id_does_not_become_the_record_id(): void
    {
        Mail::fake();
        config(['prodi.contact_email' => 'owner@example.com']);

        $this->post(route('sv.contact.store'), $this->payload([
            'id' => 999,
        ]))->assertRedirect();

        $inquiry = ContactInquiry::query()->first();

        $this->assertNotNull($inquiry);
        $this->assertNotSame(999, $inquiry->id);
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
