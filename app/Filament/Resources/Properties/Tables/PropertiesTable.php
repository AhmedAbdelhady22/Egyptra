<?php

namespace App\Filament\Resources\Properties\Tables;

use App\Filament\Resources\Properties\PropertyResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PropertiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label(__('filament.fields.featured_image')),
                TextColumn::make('title')
                    ->label(__('filament.fields.title'))
                    ->searchable()
                    ->formatStateUsing(fn ($state, $record): string => (string) ($record->getTranslation('title', app()->getLocale(), false)
                        ?: $record->getTranslation('title', 'en', false))),
                TextColumn::make('propertyType.name')
                    ->label(__('filament.fields.property_type'))
                    ->formatStateUsing(fn ($state, $record) => $record->propertyType?->getTranslation('name', app()->getLocale(), false)
                        ?: $record->propertyType?->getTranslation('name', 'en', false)),
                TextColumn::make('city.name')
                    ->label(__('filament.fields.city'))
                    ->formatStateUsing(fn ($state, $record) => $record->city?->getTranslation('name', app()->getLocale(), false)
                        ?: $record->city?->getTranslation('name', 'en', false)),
                TextColumn::make('listing_type')
                    ->label(__('filament.fields.listing_type'))
                    ->badge(),
                TextColumn::make('price')
                    ->label(__('filament.fields.price'))
                    ->money(fn ($record) => $record->currency ?? 'EGP')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('filament.fields.status'))
                    ->badge(),
                IconColumn::make('is_published')
                    ->label(__('filament.fields.is_published'))
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->emptyStateHeading(__('filament.empty_states.properties.heading'))
            ->emptyStateDescription(__('filament.empty_states.properties.description'))
            ->emptyStateIcon(Heroicon::OutlinedHomeModern)
            ->emptyStateActions([
                CreateAction::make()
                    ->label(__('filament.empty_states.properties.action'))
                    ->url(fn (): string => PropertyResource::getUrl('create')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
