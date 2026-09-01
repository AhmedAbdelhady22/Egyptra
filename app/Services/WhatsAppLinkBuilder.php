<?php

namespace App\Services;

use App\Settings\GeneralSettings;

class WhatsAppLinkBuilder
{
    public function __construct(protected GeneralSettings $settings) {}

    public function generalLink(?string $message = null): ?string
    {
        $number = $this->cleanNumber($this->settings->whatsapp_number);

        if (! $number) {
            return null;
        }

        $url = "https://wa.me/{$number}";

        if ($message) {
            $url .= '?text='.urlencode($message);
        }

        return $url;
    }

    public function propertyLink(string $title, string $propertyUrl): ?string
    {
        $message = __('Hello, I am interested in this property:')."\n{$title}\n{$propertyUrl}";

        return $this->generalLink($message);
    }

    protected function cleanNumber(?string $number): ?string
    {
        if (! $number) {
            return null;
        }

        return preg_replace('/[^0-9]/', '', $number);
    }
}
