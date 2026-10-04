<?php

use App\Http\Middleware\DiscardFilledHoneypot;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // The origin only receives public traffic through Cloudflare.
        // Trust the forwarded client IP so the quote form rate limit
        // is per visitor. Keep ports 80 and 443 closed to everyone else.
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'locale' => SetLocale::class,
            'honeypot' => DiscardFilledHoneypot::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (ThrottleRequestsException $exception, Request $request) {
            if (! $request->routeIs('*.contact.store')) {
                return false;
            }

            return back()->withErrors([
                'form' => __('site.form.throttled'),
            ])->withInput();
        });
    })->create();
