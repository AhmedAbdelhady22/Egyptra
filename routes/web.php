<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FinishingPackageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Livewire\PropertyListing;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/en');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

Route::prefix('{locale}')
    ->where(['locale' => 'en|ar|ru'])
    ->middleware('locale')
    ->group(function (): void {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/properties', PropertyListing::class)->name('properties.index');
        Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
        Route::get('/finishing-packages', [FinishingPackageController::class, 'index'])->name('packages.index');
        Route::get('/finishing-packages/{package}', [FinishingPackageController::class, 'show'])->name('packages.show');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');
    });
