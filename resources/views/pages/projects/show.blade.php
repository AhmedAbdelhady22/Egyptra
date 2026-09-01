@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $title = $project->getTranslation('title', $locale, false) ?: $project->getTranslation('title', 'en', false);
        $features = $project->getTranslation('features', $locale, false);
    @endphp

    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => __('Projects'), 'url' => route('projects.index', ['locale' => $locale])],
            ['label' => $title],
        ]" />

        @if ($project->featured_image)
            <img src="{{ asset('storage/'.$project->featured_image) }}" alt="{{ $title }}" class="mb-8 aspect-video w-full rounded-sm object-cover">
        @endif

        <h1 class="section-heading">{{ $title }}</h1>

        @if ($project->getTranslation('location', $locale, false))
            <p class="mt-2 text-ink-700">{{ $project->getTranslation('location', $locale, false) }}</p>
        @endif

        @if ($project->completed_at)
            <p class="mt-1 font-mono text-sm text-ash">{{ __('Completed') }}: {{ $project->completed_at->format('M Y') }}</p>
        @endif

        @if ($project->getTranslation('description', $locale, false))
            <div class="prose-brand mt-8">
                {!! nl2br(e($project->getTranslation('description', $locale, false))) !!}
            </div>
        @endif

        @if ($features)
            <div class="mt-10">
                <h2 class="font-display text-xl text-ink">{{ __('Features') }}</h2>
                <div class="prose-brand mt-3">{!! $features !!}</div>
            </div>
        @endif

        @if ($project->images->isNotEmpty())
            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                @foreach ($project->images as $image)
                    <img src="{{ asset('storage/'.($image->thumbnail_path ?: $image->path)) }}" alt="" class="aspect-[4/3] w-full rounded-sm object-cover" loading="lazy">
                @endforeach
            </div>
        @endif

        @if ($project->videos->isNotEmpty())
            <div class="mt-10 space-y-4">
                <h2 class="font-display text-xl text-ink">{{ __('Videos') }}</h2>
                @foreach ($project->videos as $video)
                    <x-video-embed :video="$video" />
                @endforeach
            </div>
        @endif
    </div>
@endsection
