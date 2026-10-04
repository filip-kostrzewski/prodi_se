<?php

use App\Http\Controllers\ContactInquiryController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use App\Support\Locales;
use Illuminate\Support\Facades\Route;

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

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
