<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DiscardFilledHoneypot
{
    public const FIELD = 'website_url';

    /**
     * Bots that fill the hidden field get the same thank-you as a real visitor.
     * Nothing is stored and nothing is emailed.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $value = trim((string) $request->input(self::FIELD, ''));

        if ($value !== '') {
            return back()->with('status', __('site.form.success'));
        }

        return $next($request);
    }
}
