<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $sitemapUrl = route('sitemap');

        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Sitemap: '.$sitemapUrl,
            '',
        ]);

        return response($content, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
