<?php

namespace App\Filament\Resources\PropertyTypes;

use App\Filament\Resources\PropertyTypes\Pages\CreatePropertyType;
use App\Filament\Resources\PropertyTypes\Pages\EditPropertyType;
use App\Filament\Resources\PropertyTypes\Pages\ListPropertyTypes;
use App\Filament\Resources\PropertyTypes\Schemas\PropertyTypeForm;
use App\Filament\Resources\PropertyTypes\Tables\PropertyTypesTable;
use App\Models\PropertyType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PropertyTypeResource extends Resource
{
    protected static ?string $model = PropertyType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.properties');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.labels.property_types');
    }

    public static function form(Schema $schema): Schema
    {
        return PropertyTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PropertyTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPropertyTypes::route('/'),
            'create' => CreatePropertyType::route('/create'),
            'edit' => EditPropertyType::route('/{record}/edit'),
        ];
    }
}
