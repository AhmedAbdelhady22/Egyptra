<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\MapUrlParser;
use App\Services\WhatsAppLinkBuilder;

class PropertyController extends Controller
{
    public function show(string $locale, Property $property, WhatsAppLinkBuilder $whatsapp, MapUrlParser $maps)
    {
        $property->load(['propertyType', 'city', 'area', 'compound', 'images', 'videos']);

        return view('pages.properties.show', [
            'property' => $property,
            'mapEmbedUrl' => $maps->embedUrl(
                $property->google_maps_url,
                $property->latitude ? (float) $property->latitude : null,
                $property->longitude ? (float) $property->longitude : null,
            ),
            'whatsappUrl' => $whatsapp->propertyLink(
                $property->getTranslation('title', app()->getLocale(), false)
                    ?: $property->getTranslation('title', 'en', false),
                url()->current(),
            ),
            'seoTitle' => $property->seoTitle(),
            'seoDescription' => $property->seoDescription(),
            'seoImage' => $property->ogImageUrl(),
        ]);
    }
}
