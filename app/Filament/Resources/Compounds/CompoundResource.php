<?php

namespace App\Filament\Resources\Compounds;

use App\Filament\Resources\Compounds\Pages\CreateCompound;
use App\Filament\Resources\Compounds\Pages\EditCompound;
use App\Filament\Resources\Compounds\Pages\ListCompounds;
use App\Filament\Resources\Compounds\Schemas\CompoundForm;
use App\Filament\Resources\Compounds\Tables\CompoundsTable;
use App\Models\Compound;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CompoundResource extends Resource
{
    protected static ?string $model = Compound::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.properties');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.labels.compounds');
    }

    public static function form(Schema $schema): Schema
    {
        return CompoundForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompoundsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompounds::route('/'),
            'create' => CreateCompound::route('/create'),
            'edit' => EditCompound::route('/{record}/edit'),
        ];
    }
}
