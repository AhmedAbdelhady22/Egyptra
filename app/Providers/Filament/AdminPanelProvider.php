<?php

namespace App\Providers\Filament;

use App\Http\Controllers\Filament\SwitchLocaleController;
use App\Http\Middleware\SetFilamentLocale;
use App\Settings\GeneralSettings;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName(fn (): string => app(GeneralSettings::class)->site_name)
            ->brandLogo(asset('images/brand/egyptra-logo.png'))
            ->favicon(asset('favicon.png'))
            ->colors([
                'primary' => Color::hex('#5A7D7C'),
                'gray' => Color::hex('#232C33'),
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(__('filament.navigation.groups.properties')),
                NavigationGroup::make()
                    ->label(__('filament.navigation.groups.content')),
                NavigationGroup::make()
                    ->label(__('filament.navigation.groups.leads')),
                NavigationGroup::make()
                    ->label(__('filament.navigation.groups.settings')),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([])
            ->userMenuItems([
                'locale_en' => MenuItem::make()
                    ->label(__('filament.locale.english'))
                    ->icon('heroicon-o-language')
                    ->url(fn (): string => route('filament.admin.locale.switch', ['locale' => 'en']))
                    ->visible(fn (): bool => app()->getLocale() !== 'en'),
                'locale_ar' => MenuItem::make()
                    ->label(__('filament.locale.arabic'))
                    ->icon('heroicon-o-language')
                    ->url(fn (): string => route('filament.admin.locale.switch', ['locale' => 'ar']))
                    ->visible(fn (): bool => app()->getLocale() !== 'ar'),
            ])
            ->routes(function (): void {
                Route::get('/locale/{locale}', SwitchLocaleController::class)
                    ->name('locale.switch');
            })
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetFilamentLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
