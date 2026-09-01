@extends('layouts.app')

@section('content')
    @php $locale = app()->getLocale(); @endphp

    <div class="brand-container py-10 md:py-14">
        <x-page-header
            :label="__('Finishing')"
            :title="__('Finishing Packages')"
            :description="__('Transform your space with our curated finishing options.')"
        />

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($packages as $package)
                <a href="{{ route('packages.show', ['locale' => $locale, 'package' => $package->localizedSlug()]) }}"
                   class="card-brand">
                    @if ($package->featured_image)
                        <img src="{{ asset('storage/'.$package->featured_image) }}" alt="" class="aspect-video w-full object-cover">
                    @endif
                    <div class="p-5">
                        <h2 class="font-display text-lg text-ink">{{ $package->getTranslation('name', $locale, false) }}</h2>
                        <p class="mt-2 text-sm font-medium text-teal">{{ number_format((float) $package->price_per_sqm) }} {{ $package->currency }}/m²</p>
                        <p class="mt-2 line-clamp-3 text-sm text-ink-700">{{ \Illuminate\Support\Str::limit(strip_tags($package->getTranslation('description', $locale, false)), 120) }}</p>
                    </div>
                </a>
            @empty
                <p class="text-ink-700">{{ __('No packages available yet.') }}</p>
            @endforelse
        </div>
    </div>
@endsection
