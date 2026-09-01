@props(['property'])

@php
    $locale = app()->getLocale();
    $title = $property->getTranslation('title', $locale, false) ?: $property->getTranslation('title', 'en', false);
    $slug = $property->localizedSlug($locale);
    $url = route('properties.show', ['locale' => $locale, 'property' => $slug]);
    $firstImage = $property->relationLoaded('images') ? $property->images->first() : null;
    $imagePath = $firstImage?->thumbnail_path ?: $firstImage?->path ?: $property->featured_image;
    $image = $imagePath ? asset('storage/'.$imagePath) : null;
    $location = $property->city?->getTranslation('name', $locale, false)
        ?: $property->area?->getTranslation('name', $locale, false);
    $statusLabel = $property->listing_type?->label()
        ?: $property->status?->label()
        ?: __('Available');
@endphp

<article {{ $attributes->merge(['class' => 'card-listing group']) }}
         x-data="propertyFavorite({{ $property->id }}, @js(['id' => $property->id, 'title' => $title, 'url' => $url, 'image' => $image, 'price' => $property->price, 'currency' => $property->currency, 'listing_type' => $property->listing_type?->label()]))">
    @if ($image)
        <a href="{{ $url }}" class="card-listing__media block">
            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
        </a>
    @endif

    <span class="card-status">{{ $statusLabel }}</span>

    <div class="card-listing-body">
        @if ($location)
            <p class="card-loc">{{ $location }}</p>
        @endif

        <h3 class="card-listing-title">
            <a href="{{ $url }}" class="hover:text-teal">{{ $title }}</a>
        </h3>

        <div class="card-listing-foot">
            <span class="card-price">{{ number_format((float) $property->price) }} {{ $property->currency }}</span>
            <button type="button"
                    @click.prevent="toggle()"
                    class="text-ash transition-colors hover:text-accent"
                    :class="{ 'text-accent': isFavorite }"
                    :aria-pressed="isFavorite.toString()"
                    aria-label="{{ __('Toggle favorite') }}">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </button>
        </div>

        <div class="card-specs">
            @if ($property->property_area_sqm)
                <span>{{ number_format((float) $property->property_area_sqm) }} m²</span>
            @endif
            @if ($property->bedrooms)
                <span>{{ $property->bedrooms }} {{ __('bed') }}</span>
            @endif
            @if ($property->bathrooms)
                <span>{{ $property->bathrooms }} {{ __('bath') }}</span>
            @endif
        </div>
    </div>
</article>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('propertyFavorite', (id, payload) => ({
                    id,
                    payload,
                    isFavorite: false,
                    init() {
                        this.isFavorite = this.readFavorites().some(item => item.id === this.id);
                    },
                    readFavorites() {
                        try {
                            return JSON.parse(localStorage.getItem('egyptra_favorites') || '[]');
                        } catch {
                            return [];
                        }
                    },
                    writeFavorites(items) {
                        localStorage.setItem('egyptra_favorites', JSON.stringify(items));
                        window.dispatchEvent(new CustomEvent('favorites-updated'));
                    },
                    toggle() {
                        let items = this.readFavorites();
                        if (this.isFavorite) {
                            items = items.filter(item => item.id !== this.id);
                        } else {
                            items.push(this.payload);
                        }
                        this.isFavorite = !this.isFavorite;
                        this.writeFavorites(items);
                    },
                }));
            });
        </script>
    @endpush
@endonce
