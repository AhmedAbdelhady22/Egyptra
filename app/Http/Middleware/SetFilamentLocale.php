<?php

namespace App\Http\Middleware;

use App\Support\Locale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetFilamentLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('filament_locale', Locale::DEFAULT);

        if (! in_array($locale, Locale::ADMIN, true)) {
            $locale = Locale::DEFAULT;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
