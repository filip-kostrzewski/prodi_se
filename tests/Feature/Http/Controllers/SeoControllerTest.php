<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class SeoControllerTest extends TestCase
{
    public function test_sitemap_lists_swedish_and_polish_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee(route('sv.home'), false);
        $response->assertSee(route('pl.home'), false);
        $response->assertSee(route('sv.contact'), false);
        $response->assertSee(route('pl.example.cleaning'), false);
        $response->assertSee('hreflang="pl"', false);
        $response->assertSee('hreflang="x-default"', false);
        $response->assertDontSee('<?php', false);
    }

    public function test_robots_txt_points_at_the_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap: '.url('/sitemap.xml'), false);
    }
}
