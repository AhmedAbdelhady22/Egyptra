<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->published()
            ->ordered()
            ->get();

        return view('pages.services.index', [
            'services' => $services,
            'seoTitle' => __('Services'),
            'seoDescription' => __('Explore our real estate services.'),
        ]);
    }

    public function show(string $locale, Service $service)
    {
        $service->load(['images', 'videos']);

        return view('pages.services.show', [
            'service' => $service,
            'seoTitle' => $service->seoTitle(),
            'seoDescription' => $service->seoDescription(),
            'seoImage' => $service->ogImageUrl(),
        ]);
    }
}
