<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('seo.default_title', null);
        $this->migrator->add('seo.default_description', null);
        $this->migrator->add('seo.default_og_image', null);
    }
};
