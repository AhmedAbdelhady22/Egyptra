@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
    @endphp

    {{-- Hero + searchbar (test page) --}}
    <section class="hero-block">
        <div class="brand-container relative z-[2]">
            <div class="reveal">
                <p class="hero-eyebrow">{{ __('Premium Real Estate') }}</p>
                <h1 class="hero-title">
                    {{ __("A place in Egypt's") }} <em>{{ __('next') }}</em> {{ __('address') }}
                </h1>
                <p class="hero-sub">
                    {{ __('Vetted apartments, villas and off-plan units across Egypt\'s fastest-growing districts, with pricing, payment plans and paperwork handled in one place.') }}
                </p>
            </div>
        </div>

        <div class="searchbar-shell reveal">
            <form action="{{ route('properties.index', ['locale' => $locale]) }}" method="get" class="searchbar">
                <div class="searchbar-field">
                    <label for="search-city">{{ __('Location') }}</label>
                    <select id="search-city" name="city" class="searchbar-control">
                        <option value="">{{ __('All locations') }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->getTranslation('name', $locale, false) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="searchbar-field">
                    <label for="search-property-type">{{ __('Property Type') }}</label>
                    <select id="search-property-type" name="property_type" class="searchbar-control">
                        <option value="">{{ __('All types') }}</option>
                        @foreach ($propertyTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->getTranslation('name', $locale, false) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="searchbar-field">
                    <label for="search-budget">{{ __('Budget (EGP)') }}</label>
                    <input id="search-budget" type="text" name="price_max" inputmode="numeric" class="searchbar-control" placeholder="{{ __('3,000,000 to 8,000,000') }}">
                </div>
                <div class="searchbar-action">
                    <button type="submit" class="search-btn">
                        <span>{{ __('Search Listings') }}</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Featured listings --}}
    @if ($featuredProperties->isNotEmpty())
        <section class="section-block" id="listings">
            <div class="brand-container">
                <div class="head-row reveal">
                    <div>
                        <p class="head-eyebrow">{{ __('Featured Listings') }}</p>
                        <h2 class="section-title">{{ __('Where people are moving right now') }}</h2>
                    </div>
                    <p class="head-desc">
                        {{ __('A short list, updated weekly, held to the same paperwork and pricing checks on every unit.') }}
                    </p>
                </div>

                <div class="listings-grid">
                    @foreach ($featuredProperties->take(6) as $property)
                        <x-property-card :property="$property" class="reveal" />
                    @endforeach
                </div>

                <div class="mt-14 text-center">
                    <a href="{{ route('properties.index', ['locale' => $locale]) }}" class="link-elegant">
                        {{ __('View all listings') }}
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Why Egyptra --}}
    <section class="why-section section-block" id="why">
        <div class="brand-container">
            <div class="head-row reveal">
                <div>
                    <p class="head-eyebrow head-eyebrow--sky">{{ __('Why Egyptra') }}</p>
                    <h2 class="section-title">{{ __("Buying property here isn't usually this calm") }}</h2>
                </div>
                <p class="head-desc head-desc--muted">
                    {{ __("Three things we handle so a purchase doesn't stall in month four.") }}
                </p>
            </div>

            <div class="why-grid">
                <div class="why-item reveal">
                    <p class="why-num">{{ __('Title and Contract') }}</p>
                    <h3>{{ __('Paperwork checked before you sign') }}</h3>
                    <p>{{ __("Every unit is verified against the developer's registration and delivery timeline before it's listed, not after you've paid a deposit.") }}</p>
                </div>
                <div class="why-item reveal">
                    <p class="why-num">{{ __('Payment Plans') }}</p>
                    <h3>{{ __('Plans that match your income, not the brochure') }}</h3>
                    <p>{{ __('We lay out real installment schedules in EGP and USD side by side, so the number on page one still holds on page twelve.') }}</p>
                </div>
                <div class="why-item reveal">
                    <p class="why-num">{{ __('Local Ground Team') }}</p>
                    <h3>{{ __('Someone on site for handover day') }}</h3>
                    <p>{{ __('An Egyptra advisor walks the unit with you at delivery and flags snagging issues before the keys change hands.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA band --}}
    <div class="cta-band reveal">
        <div class="brand-container flex w-full flex-wrap items-center justify-between gap-6">
            <h3 class="cta-band-title">
                {{ __('Tell us the district, budget and move-in date — we\'ll shortlist five units by Thursday.') }}
            </h3>
            @if ($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="cta-btn">{{ __('Talk to an Advisor') }}</a>
            @else
                <a href="{{ route('contact', ['locale' => $locale]) }}" class="cta-btn">{{ __('Talk to an Advisor') }}</a>
            @endif
        </div>
    </div>
@endsection

@push('structured-data')
    <x-json-ld :data="app(\App\Services\StructuredDataService::class)->organization()" />
@endpush
