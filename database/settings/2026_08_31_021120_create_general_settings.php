<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Egyptra');
        $this->migrator->add('general.logo', null);
        $this->migrator->add('general.favicon', null);
        $this->migrator->add('general.whatsapp_number', null);
        $this->migrator->add('general.phone', null);
        $this->migrator->add('general.email', null);
        $this->migrator->add('general.address', null);
        $this->migrator->add('general.google_maps_url', null);
        $this->migrator->add('general.facebook_url', null);
        $this->migrator->add('general.instagram_url', null);
        $this->migrator->add('general.linkedin_url', null);
        $this->migrator->add('general.youtube_url', null);
    }
};
