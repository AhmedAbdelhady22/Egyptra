@extends('layouts.app')

@section('content')
    @php $locale = app()->getLocale(); @endphp

    <div class="brand-container py-10 md:py-14">
        <x-page-header
            :label="__('Portfolio')"
            :title="__('Projects')"
            :description="__('Explore our portfolio of completed work.')"
        />

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($projects as $project)
                <a href="{{ route('projects.show', ['locale' => $locale, 'project' => $project->localizedSlug()]) }}"
                   class="card-brand">
                    @if ($project->featured_image)
                        <img src="{{ asset('storage/'.$project->featured_image) }}" alt="" class="aspect-video w-full object-cover">
                    @endif
                    <div class="p-5">
                        <h2 class="font-display text-lg text-ink">{{ $project->getTranslation('title', $locale, false) }}</h2>
                        @if ($project->getTranslation('location', $locale, false))
                            <p class="mt-1 text-sm text-ink-700">{{ $project->getTranslation('location', $locale, false) }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="text-ink-700">{{ __('No projects available yet.') }}</p>
            @endforelse
        </div>
    </div>
@endsection
