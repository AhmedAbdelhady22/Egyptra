<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use App\Settings\SeoSettings;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.labels.settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.navigation.groups.settings');
    }

    public function getTitle(): string
    {
        return __('filament.navigation.labels.settings');
    }

    public function mount(): void
    {
        $general = app(GeneralSettings::class);
        $seo = app(SeoSettings::class);

        $this->form->fill([
            'site_name' => $general->site_name,
            'logo' => $general->logo,
            'favicon' => $general->favicon,
            'whatsapp_number' => $general->whatsapp_number,
            'phone' => $general->phone,
            'email' => $general->email,
            'address' => $general->address,
            'google_maps_url' => $general->google_maps_url,
            'facebook_url' => $general->facebook_url,
            'instagram_url' => $general->instagram_url,
            'linkedin_url' => $general->linkedin_url,
            'youtube_url' => $general->youtube_url,
            'default_title' => $seo->default_title,
            'default_description' => $seo->default_description,
            'default_og_image' => $seo->default_og_image,
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $general = app(GeneralSettings::class);
        $general->site_name = $data['site_name'];
        $general->logo = $data['logo'];
        $general->favicon = $data['favicon'];
        $general->whatsapp_number = $data['whatsapp_number'];
        $general->phone = $data['phone'];
        $general->email = $data['email'];
        $general->address = $data['address'];
        $general->google_maps_url = $data['google_maps_url'];
        $general->facebook_url = $data['facebook_url'];
        $general->instagram_url = $data['instagram_url'];
        $general->linkedin_url = $data['linkedin_url'];
        $general->youtube_url = $data['youtube_url'];
        $general->save();

        $seo = app(SeoSettings::class);
        $seo->default_title = $data['default_title'];
        $seo->default_description = $data['default_description'];
        $seo->default_og_image = $data['default_og_image'];
        $seo->save();

        Notification::make()
            ->success()
            ->title(__('filament.settings.saved'))
            ->send();
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.sections.general_settings'))
                    ->schema([
                        TextInput::make('site_name')
                            ->label(__('filament.fields.site_name'))
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('logo')
                            ->label(__('filament.fields.logo'))
                            ->image()
                            ->directory('settings')
                            ->visibility('public'),
                        FileUpload::make('favicon')
                            ->label(__('filament.fields.favicon'))
                            ->image()
                            ->directory('settings')
                            ->visibility('public'),
                    ])
                    ->columns(2),
                Section::make(__('filament.sections.contact_social'))
                    ->schema([
                        TextInput::make('whatsapp_number')
                            ->label(__('filament.fields.whatsapp_number'))
                            ->tel(),
                        TextInput::make('phone')
                            ->label(__('filament.fields.phone'))
                            ->tel(),
                        TextInput::make('email')
                            ->label(__('filament.fields.email'))
                            ->email(),
                        Textarea::make('address')
                            ->label(__('filament.fields.address'))
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('google_maps_url')
                            ->label(__('filament.fields.google_maps_url'))
                            ->url()
                            ->columnSpanFull(),
                        TextInput::make('facebook_url')
                            ->label(__('filament.fields.facebook_url'))
                            ->url(),
                        TextInput::make('instagram_url')
                            ->label(__('filament.fields.instagram_url'))
                            ->url(),
                        TextInput::make('linkedin_url')
                            ->label(__('filament.fields.linkedin_url'))
                            ->url(),
                        TextInput::make('youtube_url')
                            ->label(__('filament.fields.youtube_url'))
                            ->url(),
                    ])
                    ->columns(2),
                Section::make(__('filament.sections.default_seo'))
                    ->schema([
                        TextInput::make('default_title')
                            ->label(__('filament.fields.default_title'))
                            ->maxLength(255),
                        Textarea::make('default_description')
                            ->label(__('filament.fields.default_description'))
                            ->rows(3),
                        FileUpload::make('default_og_image')
                            ->label(__('filament.fields.default_og_image'))
                            ->image()
                            ->directory('settings')
                            ->visibility('public'),
                    ]),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make($this->getFormActions())
                            ->alignment($this->getFormActionsAlignment())
                            ->fullWidth($this->hasFullWidthFormActions())
                            ->sticky($this->areFormActionsSticky())
                            ->key('form-actions'),
                    ]),
            ]);
    }

    protected function hasFullWidthFormActions(): bool
    {
        return false;
    }
}
