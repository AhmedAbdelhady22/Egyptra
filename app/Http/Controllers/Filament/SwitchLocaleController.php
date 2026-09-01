<?php

namespace App\Http\Controllers\Filament;

use App\Http\Controllers\Controller;
use App\Support\Locale;
use Illuminate\Http\RedirectResponse;

class SwitchLocaleController extends Controller
{
    public function __invoke(string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, Locale::ADMIN, true), 404);

        session(['filament_locale' => $locale]);

        return back();
    }
}
