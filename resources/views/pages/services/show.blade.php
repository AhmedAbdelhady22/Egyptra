@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $name = $service->getTranslation('name', $locale, false) ?: $service->getTranslation('name', 'en', false);
        $features = $service->getTranslation('features', $locale, false);
    @endphp

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => __('Services'), 'url' => route('services.index', ['locale' => $locale])],
            ['label' => $name],
        ]" />

        @if ($service->featured_image)
            <img src="{{ asset('storage/'.$service->featured_image) }}" alt="{{ $name }}" class="mb-8 aspect-video w-full rounded-sm object-cover">
        @endif

        <h1 class="section-heading">{{ $name }}</h1>

        @if ($service->getTranslation('price_info', $locale, false))
            <p class="mt-3 text-lg font-medium text-teal">{{ $service->getTranslation('price_info', $locale, false) }}</p>
        @endif

        @if ($service->getTranslation('description', $locale, false))
            <div class="prose-brand mt-8">
                {!! nl2br(e($service->getTranslation('description', $locale, false))) !!}
            </div>
        @endif

        @if ($features)
            <div class="mt-10">
                <h2 class="font-display text-xl text-ink">{{ __('Features') }}</h2>
                <div class="prose-brand mt-3">{!! $features !!}</div>
            </div>
        @endif

        @if ($service->images->isNotEmpty())
            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                @foreach ($service->images as $image)
                    <img src="{{ asset('storage/'.($image->thumbnail_path ?: $image->path)) }}" alt="" class="aspect-[4/3] w-full rounded-sm object-cover" loading="lazy">
                @endforeach
            </div>
        @endif

        @if ($service->videos->isNotEmpty())
            <div class="mt-10 space-y-4">
                <h2 class="font-display text-xl text-ink">{{ __('Videos') }}</h2>
                @foreach ($service->videos as $video)
                    <x-video-embed :video="$video" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
