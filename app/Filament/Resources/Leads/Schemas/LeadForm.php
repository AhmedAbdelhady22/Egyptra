<?php

namespace App\Filament\Resources\Leads\Schemas;

use App\Enums\LeadStatus;
use App\Models\Property;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('filament.fields.customer_name'))
                    ->required()
                    ->disabled(),
                TextInput::make('phone')
                    ->label(__('filament.fields.customer_phone'))
                    ->tel()
                    ->required()
                    ->disabled(),
                TextInput::make('email')
                    ->label(__('filament.fields.customer_email'))
                    ->email()
                    ->disabled(),
                Textarea::make('message')
                    ->label(__('filament.fields.message'))
                    ->columnSpanFull()
                    ->disabled(),
                Select::make('property_id')
                    ->label(__('filament.fields.related_property'))
                    ->relationship('property', 'title')
                    ->getOptionLabelFromRecordUsing(
                        fn (Property $record): string => (string) ($record->getTranslation('title', app()->getLocale(), false)
                            ?: $record->getTranslation('title', 'en', false)),
                    )
                    ->disabled(),
                Select::make('status')
                    ->label(__('filament.fields.status'))
                    ->options(LeadStatus::options())
                    ->required(),
                TextInput::make('source')
                    ->label(__('filament.fields.source'))
                    ->disabled(),
            ]);
    }
}
