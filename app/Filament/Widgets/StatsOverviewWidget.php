<?php

namespace App\Filament\Widgets;

use App\Enums\LeadStatus;
use App\Enums\PropertyStatus;
use App\Filament\Resources\FinishingPackages\FinishingPackageResource;
use App\Filament\Resources\Leads\LeadResource;
use App\Filament\Resources\Properties\PropertyResource;
use App\Models\FinishingPackage;
use App\Models\Lead;
use App\Models\Property;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newLeads = Lead::query()->where('status', LeadStatus::New)->count();

        return [
            Stat::make(__('filament.widgets.stats.properties'), Property::query()->count())
                ->description(__('filament.widgets.stats.properties_hint'))
                ->url(PropertyResource::getUrl('index')),
            Stat::make(__('filament.widgets.stats.available_properties'), Property::query()->where('status', PropertyStatus::Available)->count())
                ->description(__('filament.widgets.stats.available_hint'))
                ->color('success')
                ->url(PropertyResource::getUrl('index')),
            Stat::make(__('filament.widgets.stats.packages'), FinishingPackage::query()->count())
                ->description(__('filament.widgets.stats.packages_hint'))
                ->url(FinishingPackageResource::getUrl('index')),
            Stat::make(__('filament.widgets.stats.new_leads'), $newLeads)
                ->description(__('filament.widgets.stats.leads_hint'))
                ->color($newLeads > 0 ? 'danger' : 'gray')
                ->url(LeadResource::getUrl('index')),
        ];
    }
}
