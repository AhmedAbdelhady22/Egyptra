@props([
    'title' => config('app.name'),
    'description' => '',
    'image' => null,
    'canonical' => null,
])

@php
    use App\Support\Locale;

    $canonical = $canonical ?? url()->current();
    $image = $image ?: (app(\App\Settings\SeoSettings::class)->default_og_image
        ? asset('storage/'.app(\App\Settings\SeoSettings::class)->default_og_image)
        : null);
    $hreflangUrls = app(\App\Support\LocalizedUrlGenerator::class)->hreflangUrls();
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="website">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
@if ($image)
    <meta property="og:image" content="{{ $image }}">
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if ($image)
    <meta name="twitter:image" content="{{ $image }}">
@endif

@foreach ($hreflangUrls as $altLocale => $href)
    <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ $href }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ route('home', ['locale' => Locale::DEFAULT]) }}">
