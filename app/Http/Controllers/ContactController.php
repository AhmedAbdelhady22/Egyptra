<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;

class ContactController extends Controller
{
    public function index(GeneralSettings $general)
    {
        return view('pages.contact', [
            'seoTitle' => __('Contact Us'),
            'seoDescription' => __('Get in touch with :name.', ['name' => $general->site_name]),
        ]);
    }
}
