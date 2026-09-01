@props([
    'size' => 'md',
    'showName' => true,
    'variant' => 'default',
])

@php
    $siteName = app(\App\Settings\GeneralSettings::class)->site_name;
    $logoPath = app(\App\Settings\GeneralSettings::class)->logo;
    $usesDefaultLogo = ! $logoPath;
    $logoUrl = $usesDefaultLogo ? asset('images/brand/egyptra-logo.png') : asset('storage/'.$logoPath);
    $logoUrl2x = $usesDefaultLogo ? asset('images/brand/egyptra-logo@2x.png') : null;

    $sizes = [
        'sm' => 'h-8 w-8',
        'md' => 'h-9 w-9',
        'lg' => 'h-14 w-14',
        'xl' => 'h-20 w-20',
    ];

    $textSizes = [
        'sm' => 'text-base',
        'md' => 'text-lg',
        'lg' => 'text-xl',
        'xl' => 'text-2xl',
    ];

    $displaySizes = [
        'sm' => 32,
        'md' => 36,
        'lg' => 56,
        'xl' => 80,
    ];
    $displaySize = $displaySizes[$size] ?? $displaySizes['md'];

    $linkClass = match ($variant) {
        'nav' => 'inline-flex items-center gap-3',
        'footer' => 'inline-flex items-center gap-3',
        default => 'inline-flex items-center gap-3',
    };

    $nameClass = match ($variant) {
        'nav' => 'logo-wordmark',
        'footer' => 'font-display text-xl font-normal tracking-[0.04em] text-ink',
        default => 'font-display font-medium tracking-tight text-ink '.($textSizes[$size] ?? $textSizes['md']),
    };

    $displayName = $variant === 'nav'
        ? strtoupper($siteName)
        : ($variant === 'footer' ? $siteName : $siteName);
@endphp

<a {{ $attributes->merge(['class' => $linkClass]) }}>
    <img src="{{ $logoUrl }}"
         @if ($logoUrl2x) srcset="{{ $logoUrl }} 1x, {{ $logoUrl2x }} 2x" @endif
         alt="{{ $siteName }}"
         class="{{ $sizes[$size] ?? $sizes['md'] }} logo-mark shrink-0 object-cover"
         width="{{ $displaySize }}"
         height="{{ $displaySize }}">
    @if ($showName)
        <span class="{{ $nameClass }}">{{ $displayName }}</span>
    @endif
</a>
