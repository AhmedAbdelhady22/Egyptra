@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $title = $post->getTranslation('title', $locale, false) ?: $post->getTranslation('title', 'en', false);
    @endphp

    <article class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => __('Blog'), 'url' => route('blog.index', ['locale' => $locale])],
            ['label' => $title],
        ]" />

        @if ($post->featured_image)
            <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $title }}" class="mb-8 aspect-video w-full rounded-sm object-cover">
        @endif

        @if ($post->published_at)
            <time datetime="{{ $post->published_at->toDateString() }}" class="font-mono text-sm text-ash">{{ $post->published_at->format('F j, Y') }}</time>
        @endif

        <h1 class="section-heading mt-2">{{ $title }}</h1>

        <div class="prose-brand mt-8">
            {!! $post->getTranslation('content', $locale, false) !!}
        </div>
    </article>
@endsection

@push('structured-data')
    <x-json-ld :data="app(\App\Services\StructuredDataService::class)->article($post)" />
@endpush
