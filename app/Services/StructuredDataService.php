<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Property;
use App\Settings\GeneralSettings;

class StructuredDataService
{
    public function __construct(protected GeneralSettings $general) {}

    /**
     * @return array<string, mixed>
     */
    public function organization(): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateAgent',
            'name' => $this->general->site_name,
            'url' => config('app.url'),
            'telephone' => $this->general->phone,
            'email' => $this->general->email,
            'address' => $this->general->address,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function property(Property $property, ?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $title = $property->getTranslation('title', $locale, false)
            ?: $property->getTranslation('title', 'en', false);

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateListing',
            'name' => $title,
            'description' => strip_tags($property->getTranslation('description', $locale, false) ?? ''),
            'url' => route('properties.show', ['locale' => $locale, 'property' => $property->localizedSlug($locale)]),
            'offers' => [
                '@type' => 'Offer',
                'price' => (float) $property->price,
                'priceCurrency' => $property->currency,
            ],
            'floorSize' => $property->property_area_sqm ? [
                '@type' => 'QuantitativeValue',
                'value' => (float) $property->property_area_sqm,
                'unitCode' => 'MTK',
            ] : null,
            'numberOfRooms' => $property->bedrooms,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function article(BlogPost $post, ?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $title = $post->getTranslation('title', $locale, false)
            ?: $post->getTranslation('title', 'en', false);

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $title,
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'url' => route('blog.show', ['locale' => $locale, 'post' => $post->localizedSlug($locale)]),
            'author' => [
                '@type' => 'Organization',
                'name' => $this->general->site_name,
            ],
        ]);
    }
}
