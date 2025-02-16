<?php

namespace Kakarot\LaravelInitialSetup\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('X-App-Locale')) {
            // Check if the provided locale is supported, then update app locale
            if (in_array($request->header('X-App-Locale'), ['sv', 'en'])) {
                app()->setLocale($request->header('X-App-Locale'));
            }
        }

        return $next($request);
    }
}
