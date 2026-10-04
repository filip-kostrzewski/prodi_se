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
        $response->assertSee('Jag bygger en tvåspråkig hemsida på polska och svenska', false);
        $response->assertSee('4 900 kr', false);
        $response->assertSee('hreflang="pl"', false);
        $response->assertSee('hreflang="x-default"', false);
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
        $response->assertSee('Zrobię Ci dwujęzyczną stronę PL/SV', false);
        $response->assertSee(route('sv.home'), false);
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
}
