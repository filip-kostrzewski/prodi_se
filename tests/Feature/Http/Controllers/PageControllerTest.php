<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * @return array<string, array{0: string}>
     */
    public static function publicPages(): array
    {
        return [
            'swedish home' => ['sv.home'],
            'polish home' => ['pl.home'],
            'swedish contact' => ['sv.contact'],
            'polish contact' => ['pl.contact'],
            'swedish privacy' => ['sv.privacy'],
            'polish privacy' => ['pl.privacy'],
            'swedish cleaning example' => ['sv.example.cleaning'],
            'polish cleaning example' => ['pl.example.cleaning'],
            'swedish painting example' => ['sv.example.painting'],
            'polish painting services' => ['pl.example.painting.services'],
            'swedish painting gallery' => ['sv.example.painting.gallery'],
            'polish painting contact' => ['pl.example.painting.contact'],
        ];
    }

    #[DataProvider('publicPages')]
    public function test_public_pages_are_reachable(string $route): void
    {
        $this->get(route($route))->assertOk();
    }

    public function test_swedish_home_is_the_default_language(): void
    {
        $response = $this->get('/');

        $response->assertSee('<html lang="sv"', false);
        $response->assertSee('Vi bygger en tvåspråkig hemsida på svenska och polska åt ditt företag, sätter upp din Google-företagsprofil och ett kontaktformulär. Klart på cirka två veckor, från 4 900 kr exkl. moms.', false);
        $response->assertSee('från 9 900 kr, individuell offert', false);
        $response->assertSee('559214-9370', false);
        $response->assertDontSee('ungefär två veckor', false);
        $response->assertDontSee('Google Business', false);
        $response->assertDontSee('15 000', false);
        $response->assertSee('4 900 kr', false);
        $response->assertSee('Skötsel', false);
        $response->assertSee('På svenska, och på polska', false);
        $response->assertDontSee('Opieka', false);
        $response->assertDontSee('Du pratar med Filip på polska', false);
        $html = $response->getContent();
        $this->assertTrue(strpos($html, '>Start<') < strpos($html, '>Firma<'));
        $this->assertTrue(strpos($html, '>Firma<') < strpos($html, '>Individuellt<'));
        $this->assertTrue(strpos($html, '>Individuellt<') < strpos($html, '>Skötsel<'));
        $response->assertSee('images/work/evasstad.jpg', false);
        $response->assertSee('images/work/wisegent.jpg', false);
        $response->assertSee('https://evasstad.se', false);
        $response->assertSee('https://wisegent.se/se', false);
        $response->assertSee('Webbplats för städfirma — evasstad.se', false);
        $response->assertSee('Wisegent — vår egen SaaS', false);
        $response->assertSee('Egen produkt', false);
        $response->assertSee('Design by Wisegent', false);
        $response->assertDontSee('Inga kundcase att visa ännu', false);
        $response->assertSee('images/examples/cleaning-hero.jpg', false);
        $response->assertSee('images/examples/painting-hero.jpg', false);
        $response->assertSee('package=start#offert', false);
        $response->assertSee('hreflang="pl"', false);
        $response->assertSee('hreflang="x-default"', false);
        $response->assertSee('images/prodi-logo.png', false);
        $response->assertSee('alt="Prodi"', false);
        $response->assertSee('apple-touch-icon.png', false);
        $response->assertSee('favicon.ico', false);
        $response->assertDontSee('favicon.svg', false);
        $response->assertSee('og:locale" content="sv_SE"', false);
        $response->assertSee('LocalBusiness', false);
        $response->assertSee('ProfessionalService', false);
        $response->assertSee('Offer', false);
        $response->assertSee('4900', false);
        $response->assertDontSee('streetAddress', false);
        $response->assertDontSee('<?php', false);
        $response->assertDontSee('example.com', false);
    }

    public function test_polish_home_uses_polish_copy_and_links_back_to_swedish(): void
    {
        $response = $this->get('/pl');

        $response->assertSee('<html lang="pl"', false);
        $response->assertSee('images/prodi-logo.png', false);
        $response->assertSee('alt="Prodi"', false);
        $response->assertSee('Zrobię Ci dwujęzyczną stronę PL/SV', false);
        $response->assertSee('Opieka', false);
        $response->assertSee('Zbuduję stronę po polsku i szwedzku', false);
        $response->assertDontSee('Skötsel', false);
        $response->assertSee('ok. 2 tygodnie', false);
        $response->assertSee('od 9 900 kr, wycena indywidualna', false);
        $response->assertDontSee('około 2 tygodnie', false);
        $response->assertDontSee('około dwóch tygodni', false);
        $response->assertDontSee('15 000', false);
        $response->assertSee(route('sv.home'), false);
        $response->assertSee('https://evasstad.se', false);
        $response->assertSee('https://wisegent.se/se', false);
        $response->assertSee('Strona dla firmy sprzątającej — evasstad.se', false);
        $response->assertSee('Wisegent — moja własna SaaS', false);
        $response->assertSee('Własny produkt', false);
        $response->assertDontSee('Nie mamy jeszcze realizacji klientów', false);
        $response->assertSee('hreflang="sv"', false);
    }

    public function test_example_page_switches_to_the_same_example_in_the_other_language(): void
    {
        $this->get(route('sv.example.painting.gallery'))
            ->assertSee(route('pl.example.painting.gallery'), false)
            ->assertSee('Exempeldesign från Prodi', false)
            ->assertDontSee('<?php', false);
    }

    public function test_unknown_language_prefix_is_not_a_page(): void
    {
        $this->get('/en')->assertNotFound();
    }

    public function test_privacy_policy_covers_the_quote_form_and_meta_leads(): void
    {
        $this->get(route('sv.privacy'))
            ->assertOk()
            ->assertSee('Integritetspolicy', false)
            ->assertSee('Offertformuläret', false)
            ->assertSee('Lead-annonser på Meta', false)
            ->assertSee('Prodi AB, org.nr 559214-9370, Märsta.', false)
            ->assertDontSee('Besöksadress och postnummer publiceras här när de är ifyllda.', false)
            ->assertDontSee('streetAddress', false);

        $this->get(route('pl.privacy'))
            ->assertOk()
            ->assertSee('Polityka prywatności', false)
            ->assertSee('Formularz wyceny', false)
            ->assertSee('Reklamy leadowe Meta', false)
            ->assertSee('Prodi AB, org.nr 559214-9370, Märsta.', false)
            ->assertDontSee('Adres i kod pocztowy pojawią się tutaj, gdy będą uzupełnione.', false);
    }

    public function test_privacy_policy_publishes_a_street_address_only_when_it_is_set(): void
    {
        config([
            'prodi.street_address' => 'Exempelgatan 1',
            'prodi.postal_code' => '195 00',
        ]);

        $this->get(route('sv.privacy'))
            ->assertSee('Exempelgatan 1', false)
            ->assertSee('195 00', false)
            ->assertDontSee('Besöksadress och postnummer publiceras här när de är ifyllda.', false);
    }

    public function test_footer_publishes_the_org_number_and_a_real_contact_email(): void
    {
        config(['prodi.contact_email' => 'filip@prodi.se']);

        $this->get('/')
            ->assertSee('Prodi AB · org.nr 559214-9370', false)
            ->assertSee('filip@prodi.se', false)
            ->assertDontSee('example.com', false);
    }

    public function test_contact_form_preselects_a_package_from_the_query(): void
    {
        $this->get(route('sv.contact').'?package=start#offert')
            ->assertOk()
            ->assertSee('id="offert"', false)
            ->assertSee('value="start" selected', false)
            ->assertSee('inert', false)
            ->assertSee('aria-hidden="true"', false)
            ->assertDontSee('>Website<', false);
    }

    public function test_example_pages_link_to_the_quote_form_and_the_other_language(): void
    {
        $this->get(route('sv.example.cleaning'))
            ->assertOk()
            ->assertSee('images/examples/cleaning-hero.jpg', false)
            ->assertSee('08-000 00 00', false)
            ->assertSee(route('sv.contact').'?package=start#offert', false)
            ->assertSee(route('pl.example.cleaning'), false)
            ->assertDontSee('En kort text om firman', false);

        $this->get(route('sv.example.painting.gallery'))
            ->assertOk()
            ->assertSee('images/examples/painting-hero.jpg', false)
            ->assertSee('images/examples/painting-exterior.jpg', false)
            ->assertSee(route('sv.contact').'?package=firma#offert', false);
    }

    public function test_polish_example_shortcuts_redirect_to_the_real_paths(): void
    {
        $this->get('/pl/exempel/stadning')->assertRedirect('/pl/przyklady/sprzatanie');
        $this->get('/pl/exempel/malning')->assertRedirect('/pl/przyklady/malowanie');
        $this->get('/pl/exempel/malning/galleri')->assertRedirect('/pl/przyklady/malowanie/galeria');
    }

    public function test_phone_and_whatsapp_appear_only_when_a_number_is_configured(): void
    {
        $this->get('/')->assertDontSee('wa.me', false)->assertDontSee('tel:', false);

        config(['prodi.phone' => '070-000 00 00']);

        $this->get('/')
            ->assertSee('070-000 00 00', false)
            ->assertSee('tel:+46700000000', false)
            ->assertSee('https://wa.me/46700000000', false);
    }
}
