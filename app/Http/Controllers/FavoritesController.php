<?php

namespace App\Http\Controllers;

class FavoritesController extends Controller
{
    public function index()
    {
        return view('pages.favorites', [
            'seoTitle' => __('Favorites'),
            'seoDescription' => __('Your saved properties.'),
        ]);
    }
}
