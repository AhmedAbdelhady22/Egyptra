<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Property;
use App\Models\PropertyType;
use App\Services\WhatsAppLinkBuilder;
use App\Settings\GeneralSettings;
use App\Settings\SeoSettings;

class HomeController extends Controller
{
    public function index(GeneralSettings $general, SeoSettings $seo, WhatsAppLinkBuilder $whatsapp)
    {
        $featuredProperties = Property::query()
            ->published()
            ->featured()
            ->with(['propertyType', 'city', 'area', 'images'])
            ->latest('published_at')
            ->limit(6)
            ->get();

        return view('pages.home', [
            'featuredProperties' => $featuredProperties,
            'propertyTypes' => PropertyType::query()->active()->ordered()->get(),
            'cities' => City::query()->active()->ordered()->get(),
            'whatsappUrl' => $whatsapp->generalLink(__('Hello, I would like to inquire about Egyptra properties and services.')),
            'seoTitle' => $seo->default_title ?: $general->site_name,
            'seoDescription' => $seo->default_description ?: '',
        ]);
    }
}
