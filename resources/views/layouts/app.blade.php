<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ \App\Support\Locale::direction() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $general = app(\App\Settings\GeneralSettings::class);
        $siteName = $general->site_name;
        $favicon = $general->favicon ? asset('storage/'.$general->favicon) : asset('favicon.png');
    @endphp

    <link rel="icon" type="image/png" href="{{ $favicon }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital@0;1&family=Jost:ital,wght@0,300;0,400;0,500;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">

    @hasSection('seo')
        @yield('seo')
    @elseif(isset($seoTitle))
        <x-seo-meta
            :title="$seoTitle"
            :description="$seoDescription ?? ''"
            :image="$seoImage ?? null"
        />
    @else
        {!! $seo ?? '' !!}
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('structured-data')
</head>
<body class="min-h-screen bg-[#f3f4f8] font-sans text-ink antialiased">
    @php
        $locale = app()->getLocale();
        $localized = fn (string $name, array $params = []) => route($name, array_merge(['locale' => $locale], $params));
        $localizedUrl = app(\App\Support\LocalizedUrlGenerator::class);
        $switchLocale = fn (string $targetLocale): string => $localizedUrl->urlForLocale($targetLocale);

        $isNavLinkActive = function (array $link) use ($localized): bool {
            if (isset($link['children'])) {
                return collect($link['children'])->contains(
                    fn (array $child): bool => request()->routeIs($child['route'])
                );
            }

            if (($link['route'] ?? null) === 'home') {
                return request()->routeIs('home');
            }

            if (! empty($link['params'])) {
                return request()->fullUrlIs($localized($link['route'], $link['params']).'*');
            }

            return request()->routeIs($link['route']);
        };

        $primaryNav = [
            ['route' => 'home', 'params' => [], 'label' => __('Home')],
            [
                'label' => __('Services'),
                'children' => [
                    ['route' => 'services.index', 'params' => [], 'label' => __('Our Services')],
                    ['route' => 'packages.index', 'params' => [], 'label' => __('Finishing Packages')],
                ],
            ],
            ['route' => 'projects.index', 'params' => [], 'label' => __('Projects')],
            ['route' => 'blog.index', 'params' => [], 'label' => __('Blog')],
            ['route' => 'about', 'params' => [], 'label' => __('About')],
            ['route' => 'contact', 'params' => [], 'label' => __('Contact Us')],
        ];

        $mobileNav = [];
        foreach ($primaryNav as $link) {
            if (isset($link['children'])) {
                $mobileNav[] = ['route' => 'services.index', 'params' => [], 'label' => __('Services')];
                foreach ($link['children'] as $child) {
                    $mobileNav[] = [
                        'route' => $child['route'],
                        'params' => $child['params'],
                        'label' => $child['label'],
                        'indent' => true,
                    ];
                }

                continue;
            }

            $mobileNav[] = $link;
        }

        $mobileNav[] = ['route' => 'properties.index', 'params' => [], 'label' => __('All Properties')];
        $mobileNav[] = ['route' => 'favorites', 'params' => [], 'label' => __('Favorites')];

        $footerNav = [
            ['route' => 'home', 'params' => [], 'label' => __('Home')],
            ['route' => 'properties.index', 'params' => [], 'label' => __('Properties')],
            ['route' => 'services.index', 'params' => [], 'label' => __('Services')],
            ['route' => 'packages.index', 'params' => [], 'label' => __('Finishing Packages')],
            ['route' => 'projects.index', 'params' => [], 'label' => __('Projects')],
            ['route' => 'blog.index', 'params' => [], 'label' => __('Blog')],
            ['route' => 'about', 'params' => [], 'label' => __('About')],
            ['route' => 'contact', 'params' => [], 'label' => __('Contact Us')],
        ];
    @endphp

    <header class="sticky top-0 z-50 border-b border-white/8 bg-ink/98 backdrop-blur-sm" x-data="{ open: false }">
        <nav class="brand-container flex items-center justify-between gap-4 py-4">
            <x-brand-logo href="{{ $localized('home') }}" variant="nav" size="md" />

            <ul class="hidden list-none flex-wrap items-center gap-x-6 gap-y-2 xl:flex" aria-label="{{ __('Main navigation') }}">
                @foreach ($primaryNav as $link)
                    @if (isset($link['children']))
                        <li class="nav-dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button"
                                    class="nav-link inline-flex items-center gap-1"
                                    :class="{ 'is-active': {{ $isNavLinkActive($link) ? 'true' : 'false' }} }"
                                    @click="open = !open"
                                    :aria-expanded="open.toString()">
                                {{ $link['label'] }}
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div class="nav-dropdown-panel" x-show="open" x-cloak x-transition>
                                @foreach ($link['children'] as $child)
                                    <a href="{{ $localized($child['route'], $child['params']) }}"
                                       @class([
                                           'nav-dropdown-link',
                                           'is-active' => request()->routeIs($child['route']),
                                       ])>
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @else
                        <li>
                            <a href="{{ $localized($link['route'], $link['params']) }}"
                               @class([
                                   'nav-link',
                                   'is-active' => $isNavLinkActive($link),
                               ])>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <div class="hidden items-center gap-4 xl:flex">
                <div class="flex items-center border border-white/10 bg-ink-soft p-0.5 font-mono text-[10px] uppercase tracking-wider">
                    @foreach (\App\Support\Locale::PUBLIC as $code)
                        <a href="{{ $switchLocale($code) }}"
                           @class([
                               'px-2 py-1 transition-colors',
                               'bg-teal text-lavender' => $locale === $code,
                               'text-ash hover:text-lavender' => $locale !== $code,
                           ])>
                            {{ strtoupper($code) }}
                        </a>
                    @endforeach
                </div>
                <a href="{{ $localized('contact') }}" class="nav-cta">{{ __('Book a Viewing') }}</a>
            </div>

            <button type="button"
                    class="inline-flex items-center justify-center p-2 text-lavender xl:hidden"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                    aria-controls="mobile-nav">
                <span class="sr-only">{{ __('Toggle menu') }}</span>
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </nav>

        <div id="mobile-nav"
             class="border-t border-white/10 bg-ink px-8 py-4 xl:hidden"
             x-show="open"
             x-cloak
             @click.outside="open = false">
            <nav class="flex flex-col gap-3" aria-label="{{ __('Mobile navigation') }}">
                @foreach ($mobileNav as $link)
                    <a href="{{ $localized($link['route'], $link['params']) }}"
                       @class([
                           'nav-link',
                           'ps-4' => ! empty($link['indent']),
                       ])>
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <a href="{{ $localized('contact') }}" class="nav-cta mt-2 w-fit">{{ __('Book a Viewing') }}</a>
                <div class="flex gap-2 border-t border-white/10 pt-3">
                    @foreach (\App\Support\Locale::PUBLIC as $code)
                        <a href="{{ $switchLocale($code) }}"
                           class="border border-white/10 px-3 py-1.5 font-mono text-xs uppercase tracking-wider text-ash hover:text-lavender">
                            {{ \App\Support\Locale::label($code) }}
                        </a>
                    @endforeach
                </div>
            </nav>
        </div>
    </header>

    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    <footer class="site-footer">
        <div class="brand-container">
            <div class="grid gap-10 border-b border-[#23293122] pb-10 md:grid-cols-[1.4fr_1fr_1fr]">
                <div>
                    <x-brand-logo href="{{ $localized('home') }}" variant="footer" size="sm" />
                    <p class="mt-4 max-w-xs text-sm leading-relaxed text-[#4a5560]">
                        {{ __('Premium real estate in Egypt.') }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-[0.12em] text-teal">{{ __('Explore') }}</p>
                    <ul class="mt-4 space-y-2">
                        @foreach (array_slice($footerNav, 0, 4) as $link)
                            <li>
                                <a href="{{ $localized($link['route'], $link['params']) }}"
                                   class="text-sm text-[#3a4249] transition-colors hover:text-ink">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-[0.12em] text-teal">{{ __('Company') }}</p>
                    <ul class="mt-4 space-y-2">
                        @foreach (array_slice($footerNav, 4) as $link)
                            <li>
                                <a href="{{ $localized($link['route'], $link['params']) }}"
                                   class="text-sm text-[#3a4249] transition-colors hover:text-ink">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="foot-bottom mt-8">
                <span>&copy; {{ date('Y') }} {{ $siteName }}</span>
                <span>{{ __('Licensed Real Estate Marketplace, Egypt') }}</span>
            </div>
        </div>
    </footer>

    <x-whatsapp-button />

    @stack('scripts')

    <style>[x-cloak]{display:none!important}</style>
</body>
</html>
