<?php

namespace App\Http\Controllers;

use App\Models\FinishingPackage;

class FinishingPackageController extends Controller
{
    public function index()
    {
        $packages = FinishingPackage::query()
            ->published()
            ->ordered()
            ->get();

        return view('pages.packages.index', [
            'packages' => $packages,
            'seoTitle' => __('Finishing Packages'),
            'seoDescription' => __('Premium finishing packages for your property.'),
        ]);
    }

    public function show(string $locale, FinishingPackage $package)
    {
        $package->load(['images', 'videos']);

        return view('pages.packages.show', [
            'package' => $package,
            'seoTitle' => $package->seoTitle(),
            'seoDescription' => $package->seoDescription(),
            'seoImage' => $package->ogImageUrl(),
        ]);
    }
}
