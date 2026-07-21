<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales.
     */
    protected array $supported = ['en', 'fil', 'ja', 'ko', 'zh', 'es'];

    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check session first
        $locale = session('locale');

        // 2. Validate it; if invalid fall back to app default
        if (!$locale || !in_array($locale, $this->supported)) {
            $locale = config('app.locale', 'en');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
