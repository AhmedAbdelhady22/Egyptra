<?php

namespace App\Providers;

use App\Livewire\ContactForm;
use App\Livewire\PropertyListing;
use App\Models\BlogPost;
use App\Models\FinishingPackage;
use App\Models\FinishingPackageImage;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Observers\BlogPostObserver;
use App\Observers\FinishingPackageImageObserver;
use App\Observers\FinishingPackageObserver;
use App\Observers\ProjectImageObserver;
use App\Observers\ProjectObserver;
use App\Observers\PropertyImageObserver;
use App\Observers\PropertyObserver;
use App\Observers\ServiceImageObserver;
use App\Observers\ServiceObserver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('property-listing', PropertyListing::class);
        Livewire::component('contact-form', ContactForm::class);

        Property::observe(PropertyObserver::class);
        PropertyImage::observe(PropertyImageObserver::class);
        Service::observe(ServiceObserver::class);
        ServiceImage::observe(ServiceImageObserver::class);
        FinishingPackage::observe(FinishingPackageObserver::class);
        FinishingPackageImage::observe(FinishingPackageImageObserver::class);
        Project::observe(ProjectObserver::class);
        ProjectImage::observe(ProjectImageObserver::class);
        BlogPost::observe(BlogPostObserver::class);

        Route::bind('package', function (string $value): FinishingPackage {
            $model = (new FinishingPackage)->resolveRouteBinding($value);

            if (! $model) {
                throw (new ModelNotFoundException)->setModel(FinishingPackage::class, [$value]);
            }

            return $model;
        });

        Route::bind('post', function (string $value): BlogPost {
            $model = (new BlogPost)->resolveRouteBinding($value);

            if (! $model) {
                throw (new ModelNotFoundException)->setModel(BlogPost::class, [$value]);
            }

            return $model;
        });
    }
}
