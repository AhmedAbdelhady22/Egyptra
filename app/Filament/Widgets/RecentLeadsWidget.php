<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentLeadsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('filament.widgets.recent_leads'))
            ->query(
                Lead::query()->latest()->limit(5),
            )
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.fields.customer_name')),
                TextColumn::make('phone')
                    ->label(__('filament.fields.customer_phone')),
                TextColumn::make('email')
                    ->label(__('filament.fields.customer_email')),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordUrl(fn (Lead $record): string => LeadResource::getUrl('edit', ['record' => $record]))
            ->paginated(false);
    }
}
