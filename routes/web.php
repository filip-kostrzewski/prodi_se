<?php

use App\Http\Controllers\ContactInquiryController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use App\Support\Locales;
use Illuminate\Support\Facades\Route;

Route::redirect('/pl/exempel/stadning', '/pl/przyklady/sprzatanie', 301);
Route::redirect('/pl/exempel/malning/tjanster', '/pl/przyklady/malowanie/uslugi', 301);
Route::redirect('/pl/exempel/malning/galleri', '/pl/przyklady/malowanie/galeria', 301);
Route::redirect('/pl/exempel/malning/kontakt', '/pl/przyklady/malowanie/kontakt', 301);
Route::redirect('/pl/exempel/malning', '/pl/przyklady/malowanie', 301);

foreach (Locales::DEFINITIONS as $code => $definition) {
    $registrar = Route::middleware('locale:'.$code)->name($code.'.');

    if ($definition['prefix'] !== '') {
        $registrar = $registrar->prefix($definition['prefix']);
    }

    $registrar->group(function () use ($code): void {
        $path = fn (string $page): string => Locales::uri($page, $code);

        Route::get('/', [PageController::class, 'home'])->name('home');
        Route::get($path('contact'), [PageController::class, 'contact'])->name('contact');
        Route::post($path('contact'), [ContactInquiryController::class, 'store'])
            ->middleware(['throttle:contact', 'honeypot'])
            ->name('contact.store');
        Route::get($path('privacy'), [PageController::class, 'privacy'])->name('privacy');

        Route::get($path('example.cleaning'), [ExampleController::class, 'cleaning'])->name('example.cleaning');
        Route::get($path('example.painting'), [ExampleController::class, 'painting'])->name('example.painting');
        Route::get($path('example.painting.services'), [ExampleController::class, 'paintingServices'])->name('example.painting.services');
        Route::get($path('example.painting.gallery'), [ExampleController::class, 'paintingGallery'])->name('example.painting.gallery');
        Route::get($path('example.painting.contact'), [ExampleController::class, 'paintingContact'])->name('example.painting.contact');
    });
}

// Hidden preview of the Däckflow booking widget. It stays outside the
// locale group so it is not copied under /pl, linked from the language
// switcher, or published by the sitemap (that only lists Locales::PATHS).
Route::get('/dackflow-test', [PageController::class, 'dackflowPreview'])->name('dackflow-preview');

// Hidden client presentation for the Polfood business cards. Same
// constraints as the Däckflow preview: outside the locale group, so it
// is not copied under /pl, linked from the menu or language switcher,
// or published by the sitemap (that only lists Locales::PATHS).
Route::middleware('locale:pl')
    ->get('/p/polfood-wizytowki-k7m4', [PageController::class, 'polfoodPreview'])
    ->name('polfood-preview');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
