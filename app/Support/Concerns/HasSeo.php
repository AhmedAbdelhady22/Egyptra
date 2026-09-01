<?php

namespace App\Support\Concerns;

use App\Services\SeoService;

trait HasSeo
{
    public function seoTitle(?string $locale = null): string
    {
        return app(SeoService::class)->title($this, $locale);
    }

    public function seoDescription(?string $locale = null): string
    {
        return app(SeoService::class)->description($this, $locale);
    }

    public function ogImageUrl(): ?string
    {
        return app(SeoService::class)->ogImage($this);
    }
}
