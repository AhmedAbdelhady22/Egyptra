<?php

namespace App\Filament\Resources\FinishingPackages;

use App\Filament\Resources\FinishingPackages\Pages\CreateFinishingPackage;
use App\Filament\Resources\FinishingPackages\Pages\EditFinishingPackage;
use App\Filament\Resources\FinishingPackages\Pages\ListFinishingPackages;
use App\Filament\Resources\FinishingPackages\Schemas\FinishingPackageForm;
use App\Filament\Resources\FinishingPackages\Tables\FinishingPackagesTable;
use App\Models\FinishingPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FinishingPackageResource extends Resource
{
    protected static ?string $model = FinishingPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.labels.finishing_packages');
    }

    public static function form(Schema $schema): Schema
    {
        return FinishingPackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FinishingPackagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFinishingPackages::route('/'),
            'create' => CreateFinishingPackage::route('/create'),
            'edit' => EditFinishingPackage::route('/{record}/edit'),
        ];
    }
}
