@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $title = $property->getTranslation('title', $locale, false) ?: $property->getTranslation('title', 'en', false);
        $features = $property->getTranslation('features', $locale, false);
        $heroImage = $property->images->first()?->path ?? $property->featured_image;
    @endphp

    <div class="brand-container py-10 md:py-14">
        <x-breadcrumb :items="[
            ['label' => __('Properties'), 'url' => route('properties.index', ['locale' => $locale])],
            ['label' => $title],
        ]" />

        <div class="grid gap-10 lg:grid-cols-[1.4fr_1fr]">
            <div>
                @if ($property->images->isNotEmpty())
                    <div class="grid gap-3">
                        @if ($heroImage)
                            <img src="{{ asset('storage/'.$heroImage) }}" alt="{{ $title }}" class="aspect-[16/10] w-full object-cover">
                        @endif
                        @if ($property->images->count() > 1)
                            <div class="grid gap-3 sm:grid-cols-3">
                                @foreach ($property->images->skip(1) as $image)
                                    <img src="{{ asset('storage/'.$image->path) }}" alt="{{ $title }}" class="aspect-[4/3] w-full object-cover" loading="lazy">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @elseif ($property->featured_image)
                    <img src="{{ asset('storage/'.$property->featured_image) }}" alt="{{ $title }}" class="aspect-[16/10] w-full object-cover">
                @endif

                <div class="mt-8 space-y-6">
                    <div>
                        <h1 class="section-heading">{{ $title }}</h1>
                        <p class="mt-3 font-display text-2xl font-medium text-teal">{{ number_format((float) $property->price) }} {{ $property->currency }}</p>
                    </div>

                    <div class="flex flex-wrap gap-3 text-sm text-ink-700">
                        @if ($property->listing_type)
                            <span class="badge-brand badge-brand--lavender">{{ $property->listing_type->label() }}</span>
                        @endif
                        @if ($property->status)
                            <span class="badge-brand badge-brand--teal">{{ $property->status->label() }}</span>
                        @endif
                        @if ($property->propertyType)
                            <span class="brand-meta normal-case">{{ $property->propertyType->getTranslation('name', $locale, false) }}</span>
                        @endif
                        @if ($property->city)
                            <span class="brand-meta normal-case">{{ $property->city->getTranslation('name', $locale, false) }}</span>
                        @endif
                        @if ($property->area)
                            <span class="brand-meta normal-case">{{ $property->area->getTranslation('name', $locale, false) }}</span>
                        @endif
                        @if ($property->bedrooms)
                            <span class="brand-meta normal-case">{{ $property->bedrooms }} {{ __('Beds') }}</span>
                        @endif
                        @if ($property->bathrooms)
                            <span class="brand-meta normal-case">{{ $property->bathrooms }} {{ __('Baths') }}</span>
                        @endif
                        @if ($property->property_area_sqm)
                            <span class="brand-meta normal-case">{{ number_format((float) $property->property_area_sqm) }} m²</span>
                        @endif
                        @if ($property->floor)
                            <span class="brand-meta normal-case">{{ __('Floor') }} {{ $property->floor }}</span>
                        @endif
                    </div>

                    @if ($property->getTranslation('description', $locale, false))
                        <div class="prose-brand">
                            {!! nl2br(e($property->getTranslation('description', $locale, false))) !!}
                        </div>
                    @endif

                    @if ($features)
                        <div>
                            <h2 class="font-display text-xl text-ink">{{ __('Features') }}</h2>
                            <div class="prose-brand mt-3">
                                {!! $features !!}
                            </div>
                        </div>
                    @endif

                    @if ($property->videos->isNotEmpty())
                        <div class="space-y-4">
                            <h2 class="font-display text-xl text-ink">{{ __('Videos') }}</h2>
                            @foreach ($property->videos as $video)
                                <x-video-embed :video="$video" />
                            @endforeach
                        </div>
                    @endif

                    @if ($mapEmbedUrl)
                        <div class="space-y-3">
                            <h2 class="font-display text-xl text-ink">{{ __('Location') }}</h2>
                            <div class="overflow-hidden border border-lavender-200">
                                <iframe src="{{ $mapEmbedUrl }}" class="aspect-[16/10] w-full" loading="lazy" title="{{ __('Property location map') }}"></iframe>
                            </div>
                            @if ($property->google_maps_url)
                                <a href="{{ $property->google_maps_url }}" target="_blank" rel="noopener" class="inline-flex text-sm font-medium text-teal hover:text-teal-700">
                                    {{ __('Open in Google Maps') }} →
                                </a>
                            @endif
                        </div>
                    @elseif ($property->google_maps_url)
                        <a href="{{ $property->google_maps_url }}" target="_blank" rel="noopener" class="inline-flex text-sm font-medium text-teal hover:text-teal-700">
                            {{ __('View on Google Maps') }} →
                        </a>
                    @endif
                </div>
            </div>

            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                @if ($whatsappUrl)
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn-whatsapp w-full">
                        {{ __('WhatsApp Inquiry') }}
                    </a>
                @endif

                <div class="border border-lavender-200 bg-lavender-50 p-6">
                    <h2 class="font-display text-lg text-ink">{{ __('Request Information') }}</h2>
                    <p class="mt-1 text-sm text-ink-700">{{ __('Leave your details and we will get back to you.') }}</p>
                    <div class="mt-5">
                        <livewire:contact-form :property-id="$property->id" />
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('structured-data')
    <x-json-ld :data="app(\App\Services\StructuredDataService::class)->property($property)" />
@endpush
