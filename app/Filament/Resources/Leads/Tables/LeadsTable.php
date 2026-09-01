<?php

namespace App\Filament\Resources\Leads\Tables;

use App\Enums\LeadStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.fields.customer_name'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('filament.fields.customer_phone'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('filament.fields.customer_email'))
                    ->searchable(),
                TextColumn::make('property.title')
                    ->label(__('filament.fields.related_property'))
                    ->formatStateUsing(fn ($state, $record) => $record->property
                        ? ($record->property->getTranslation('title', app()->getLocale(), false)
                            ?: $record->property->getTranslation('title', 'en', false))
                        : null),
                TextColumn::make('status')
                    ->label(__('filament.fields.status'))
                    ->badge()
                    ->color(fn (LeadStatus $state): string => match ($state) {
                        LeadStatus::New => 'info',
                        LeadStatus::Contacted => 'warning',
                        LeadStatus::Closed => 'success',
                    }),
                TextColumn::make('source')
                    ->label(__('filament.fields.source'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
