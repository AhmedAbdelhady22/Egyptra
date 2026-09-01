<?php

namespace App\Services;

use App\Settings\GeneralSettings;
use App\Settings\SeoSettings;
use Illuminate\Support\Str;

class SeoService
{
    public function __construct(
        protected GeneralSettings $general,
        protected SeoSettings $seo,
    ) {}

    public function title(object $entity, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $siteName = $this->general->site_name;

        if (method_exists($entity, 'getTranslation')) {
            $seoTitle = $entity->getTranslation('seo_title', $locale, false);
            if ($seoTitle) {
                return $seoTitle;
            }

            $title = $this->translatedValue($entity, ['title', 'name'], $locale);

            if ($title) {
                return "{$title} | {$siteName}";
            }
        }

        return $this->seo->default_title ?: $siteName;
    }

    public function description(object $entity, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        if (method_exists($entity, 'getTranslation')) {
            $seoDescription = $entity->getTranslation('seo_description', $locale, false);
            if ($seoDescription) {
                return $seoDescription;
            }

            $description = $this->translatedValue($entity, ['description', 'content'], $locale);

            if ($description) {
                return Str::limit(strip_tags($description), 160);
            }
        }

        return $this->seo->default_description ?: '';
    }

    public function ogImage(object $entity): ?string
    {
        if (property_exists($entity, 'og_image') && $entity->og_image) {
            return asset('storage/'.$entity->og_image);
        }

        if (property_exists($entity, 'featured_image') && $entity->featured_image) {
            return asset('storage/'.$entity->featured_image);
        }

        if ($this->seo->default_og_image) {
            return asset('storage/'.$this->seo->default_og_image);
        }

        return null;
    }

    /**
     * @param  list<string>  $attributes
     */
    protected function translatedValue(object $entity, array $attributes, string $locale): ?string
    {
        if (! property_exists($entity, 'translatable') || ! is_array($entity->translatable)) {
            return null;
        }

        foreach ($attributes as $attribute) {
            if (! in_array($attribute, $entity->translatable, true)) {
                continue;
            }

            $value = $entity->getTranslation($attribute, $locale, false);

            if ($value) {
                return $value;
            }
        }

        return null;
    }
}
