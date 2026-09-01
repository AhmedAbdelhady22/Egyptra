@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $name = $package->getTranslation('name', $locale, false) ?: $package->getTranslation('name', 'en', false);
    @endphp

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => __('Finishing Packages'), 'url' => route('packages.index', ['locale' => $locale])],
            ['label' => $name],
        ]" />

        @if ($package->featured_image)
            <img src="{{ asset('storage/'.$package->featured_image) }}" alt="{{ $name }}" class="mb-8 aspect-video w-full rounded-sm object-cover">
        @endif

        <h1 class="section-heading">{{ $name }}</h1>
        <p class="mt-3 text-lg font-medium text-teal">{{ number_format((float) $package->price_per_sqm) }} {{ $package->currency }}/m²</p>

        @if ($package->getTranslation('description', $locale, false))
            <div class="prose-brand mt-8">
                {!! nl2br(e($package->getTranslation('description', $locale, false))) !!}
            </div>
        @endif

        @if ($package->images->isNotEmpty())
            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                @foreach ($package->images as $image)
                    <img src="{{ asset('storage/'.($image->thumbnail_path ?: $image->path)) }}" alt="" class="aspect-[4/3] w-full rounded-sm object-cover" loading="lazy">
                @endforeach
            </div>
        @endif

        @if ($package->videos->isNotEmpty())
            <div class="mt-10 space-y-4">
                <h2 class="font-display text-xl text-ink">{{ __('Videos') }}</h2>
                @foreach ($package->videos as $video)
                    <x-video-embed :video="$video" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
