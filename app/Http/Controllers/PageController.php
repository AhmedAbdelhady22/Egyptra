<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Settings\GeneralSettings;

class PageController extends Controller
{
    public function about(GeneralSettings $general)
    {
        $page = Page::query()
            ->published()
            ->where('slug', 'about')
            ->firstOrFail();

        return view('pages.about', [
            'page' => $page,
            'seoTitle' => $page->seoTitle(),
            'seoDescription' => $page->seoDescription(),
            'seoImage' => $page->ogImageUrl(),
        ]);
    }
}
