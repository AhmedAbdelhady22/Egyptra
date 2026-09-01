<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\FinishingPackage;
use App\Models\Project;
use App\Models\Property;
use App\Models\Service;
use App\Support\Locale;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url as SitemapUrl;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = Sitemap::create();

        foreach (Locale::PUBLIC as $locale) {
            $this->addStaticUrls($sitemap, $locale);
            $this->addPropertyUrls($sitemap, $locale);
            $this->addServiceUrls($sitemap, $locale);
            $this->addPackageUrls($sitemap, $locale);
            $this->addProjectUrls($sitemap, $locale);
            $this->addBlogUrls($sitemap, $locale);
        }

        return $sitemap->toResponse(request());
    }

    protected function addStaticUrls(Sitemap $sitemap, string $locale): void
    {
        $routes = [
            'home',
            'properties.index',
            'services.index',
            'packages.index',
            'projects.index',
            'blog.index',
            'about',
            'contact',
            'favorites',
        ];

        foreach ($routes as $routeName) {
            $sitemap->add(
                SitemapUrl::create(route($routeName, ['locale' => $locale]))
                    ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }
    }

    protected function addPropertyUrls(Sitemap $sitemap, string $locale): void
    {
        Property::query()
            ->published()
            ->orderBy('id')
            ->chunk(100, function ($properties) use ($sitemap, $locale): void {
                foreach ($properties as $property) {
                    $slug = $property->localizedSlug($locale);

                    if (! $slug) {
                        continue;
                    }

                    $sitemap->add(
                        SitemapUrl::create(route('properties.show', ['locale' => $locale, 'property' => $slug]))
                            ->setLastModificationDate($property->updated_at)
                            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_DAILY)
                            ->setPriority(0.9)
                    );
                }
            });
    }

    protected function addServiceUrls(Sitemap $sitemap, string $locale): void
    {
        Service::query()
            ->published()
            ->orderBy('id')
            ->chunk(100, function ($services) use ($sitemap, $locale): void {
                foreach ($services as $service) {
                    $slug = $service->localizedSlug($locale);

                    if (! $slug) {
                        continue;
                    }

                    $sitemap->add(
                        SitemapUrl::create(route('services.show', ['locale' => $locale, 'service' => $slug]))
                            ->setLastModificationDate($service->updated_at)
                            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.7)
                    );
                }
            });
    }

    protected function addPackageUrls(Sitemap $sitemap, string $locale): void
    {
        FinishingPackage::query()
            ->published()
            ->orderBy('id')
            ->chunk(100, function ($packages) use ($sitemap, $locale): void {
                foreach ($packages as $package) {
                    $slug = $package->localizedSlug($locale);

                    if (! $slug) {
                        continue;
                    }

                    $sitemap->add(
                        SitemapUrl::create(route('packages.show', ['locale' => $locale, 'package' => $slug]))
                            ->setLastModificationDate($package->updated_at)
                            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.7)
                    );
                }
            });
    }

    protected function addProjectUrls(Sitemap $sitemap, string $locale): void
    {
        Project::query()
            ->published()
            ->orderBy('id')
            ->chunk(100, function ($projects) use ($sitemap, $locale): void {
                foreach ($projects as $project) {
                    $slug = $project->localizedSlug($locale);

                    if (! $slug) {
                        continue;
                    }

                    $sitemap->add(
                        SitemapUrl::create(route('projects.show', ['locale' => $locale, 'project' => $slug]))
                            ->setLastModificationDate($project->updated_at)
                            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(0.6)
                    );
                }
            });
    }

    protected function addBlogUrls(Sitemap $sitemap, string $locale): void
    {
        BlogPost::query()
            ->published()
            ->orderBy('id')
            ->chunk(100, function ($posts) use ($sitemap, $locale): void {
                foreach ($posts as $post) {
                    $slug = $post->localizedSlug($locale);

                    if (! $slug) {
                        continue;
                    }

                    $sitemap->add(
                        SitemapUrl::create(route('blog.show', ['locale' => $locale, 'post' => $slug]))
                            ->setLastModificationDate($post->updated_at)
                            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.6)
                    );
                }
            });
    }
}
