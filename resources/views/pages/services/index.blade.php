@extends('layouts.app')

@section('content')
    @php $locale = app()->getLocale(); @endphp

    <div class="brand-container py-10 md:py-14">
        <x-page-header
            :title="__('Services')"
            :description="__('Professional real estate services tailored to your needs.')"
        />

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($services as $service)
                <a href="{{ route('services.show', ['locale' => $locale, 'service' => $service->localizedSlug()]) }}"
                   class="card-brand">
                    @if ($service->featured_image)
                        <img src="{{ asset('storage/'.$service->featured_image) }}" alt="" class="aspect-video w-full object-cover">
                    @endif
                    <div class="p-5">
                        <h2 class="font-display text-lg text-ink">{{ $service->getTranslation('name', $locale, false) }}</h2>
                        <p class="mt-2 line-clamp-3 text-sm text-ink-700">{{ \Illuminate\Support\Str::limit(strip_tags($service->getTranslation('description', $locale, false)), 140) }}</p>
                    </div>
                </a>
            @empty
                <p class="text-ink-700">{{ __('No services available yet.') }}</p>
            @endforelse
        </div>
    </div>
@endsection
