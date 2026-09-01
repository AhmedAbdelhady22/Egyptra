@extends('layouts.app')

@section('content')
    @php $locale = app()->getLocale(); @endphp

    <div class="brand-container py-10 md:py-14"
         x-data="favoritesPage()"
         @favorites-updated.window="load()">
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <x-page-header
                :title="__('Favorites')"
                :description="__('Properties you saved on this device.')"
            />
            <button type="button"
                    x-show="items.length > 0"
                    @click="clearAll()"
                    class="text-sm font-medium text-ink-700 hover:text-teal">
                {{ __('Clear all') }}
            </button>
        </div>

        <template x-if="items.length === 0">
            <div class="rounded-sm border border-dashed border-lavender-200 bg-lavender-50 p-12 text-center">
                <p class="text-ink-700">{{ __('No favorites yet.') }}</p>
                <a href="{{ route('properties.index', ['locale' => $locale]) }}" class="btn-primary mt-4">
                    {{ __('Browse Properties') }}
                </a>
            </div>
        </template>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3" x-show="items.length > 0">
            <template x-for="item in items" :key="item.id">
                <article class="card-brand">
                    <div class="aspect-[4/3] bg-lavender-100">
                        <img :src="item.image" :alt="item.title" class="h-full w-full object-cover" x-show="item.image">
                    </div>
                    <div class="space-y-2 p-4">
                        <h2 class="font-display text-ink" x-text="item.title"></h2>
                        <p class="text-sm text-ink-700" x-text="item.listing_type"></p>
                        <p class="font-semibold text-teal" x-text="formatPrice(item)"></p>
                        <a :href="item.url" class="inline-flex text-sm font-medium text-teal hover:text-teal-700">{{ __('View property') }} →</a>
                    </div>
                </article>
            </template>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('favoritesPage', () => ({
                items: [],
                init() {
                    this.load();
                },
                load() {
                    try {
                        this.items = JSON.parse(localStorage.getItem('egyptra_favorites') || '[]');
                    } catch {
                        this.items = [];
                    }
                },
                clearAll() {
                    localStorage.removeItem('egyptra_favorites');
                    this.items = [];
                    window.dispatchEvent(new CustomEvent('favorites-updated'));
                },
                formatPrice(item) {
                    if (!item.price) return '';
                    return new Intl.NumberFormat().format(item.price) + ' ' + (item.currency || '');
                },
            }));
        });
    </script>
@endpush
