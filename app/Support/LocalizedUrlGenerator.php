<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class LocalizedUrlGenerator
{
    public function urlForLocale(string $targetLocale): string
    {
        $route = Route::current();

        if ($route === null || $route->getName() === null) {
            return url('/'.$targetLocale);
        }

        foreach ($route->parameters() as $key => $parameter) {
            if ($parameter instanceof Model && method_exists($parameter, 'localizedSlug')) {
                $slug = $parameter->localizedSlug($targetLocale);

                if ($slug) {
                    $parameters = array_merge($route->parameters(), [
                        'locale' => $targetLocale,
                        $key => $slug,
                    ]);

                    return route($route->getName(), $parameters);
                }
            }
        }

        $segments = request()->segments();

        if (count($segments) > 0 && in_array($segments[0], Locale::PUBLIC, true)) {
            $segments[0] = $targetLocale;
        } else {
            array_unshift($segments, $targetLocale);
        }

        return url(implode('/', $segments));
    }

    /**
     * @return array<string, string>
     */
    public function hreflangUrls(): array
    {
        $urls = [];

        foreach (Locale::PUBLIC as $locale) {
            $urls[$locale] = $this->urlForLocale($locale);
        }

        return $urls;
    }
}
