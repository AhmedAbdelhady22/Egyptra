<div class="brand-container py-10 md:py-14" x-data="{ filtersOpen: false }">
    <div class="mb-8 reveal">
        <h1 class="section-heading">{{ __('Properties') }}</h1>
        <p class="mt-2 lead-text">{{ __('Filter and browse available listings.') }}</p>
    </div>

    <div class="mb-4 flex items-center justify-between gap-4 lg:hidden">
        <button type="button"
                @click="filtersOpen = true"
                class="btn-secondary px-4 py-2.5">
            {{ __('Filters') }}
        </button>
        <select wire:model.live="sort" class="input-brand w-auto">
            @foreach ($sortOptions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid gap-8 lg:grid-cols-[280px_1fr]">
        <aside class="filter-panel hidden lg:block">
            <x-property-filters
                :property-types="$propertyTypes"
                :cities="$cities"
                :areas="$areas"
                :compounds="$compounds"
                :listing-types="$listingTypes"
                :furnished-types="$furnishedTypes"
                :statuses="$statuses"
            />
        </aside>

        <div x-show="filtersOpen"
             x-cloak
             class="fixed inset-0 z-50 lg:hidden"
             @keydown.escape.window="filtersOpen = false">
            <div class="absolute inset-0 bg-ink/40" @click="filtersOpen = false"></div>
            <div class="absolute inset-y-0 start-0 flex w-full max-w-sm flex-col bg-white shadow-xl"
                 @click.stop>
                <div class="flex items-center justify-between border-b border-lavender-200 px-5 py-4">
                    <h2 class="font-display text-lg text-ink">{{ __('Filters') }}</h2>
                    <button type="button" @click="filtersOpen = false" class="text-sm font-medium text-teal">
                        {{ __('Close') }}
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-5">
                    <x-property-filters
                        :property-types="$propertyTypes"
                        :cities="$cities"
                        :areas="$areas"
                        :compounds="$compounds"
                        :listing-types="$listingTypes"
                        :furnished-types="$furnishedTypes"
                        :statuses="$statuses"
                    />
                </div>
            </div>
        </div>

        <div>
            <div class="mb-6 hidden flex-wrap items-center justify-between gap-4 lg:flex">
                <p class="text-sm text-ink-700">{{ __(':count results', ['count' => $properties->total()]) }}</p>
                <select wire:model.live="sort" class="input-brand w-auto">
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <p class="mb-4 text-sm text-ink-700 lg:hidden">{{ __(':count results', ['count' => $properties->total()]) }}</p>

            @if ($properties->isEmpty())
                <div class="rounded-sm border border-dashed border-lavender-200 bg-lavender-50 p-12 text-center">
                    <p class="text-ink-700">{{ __('No properties match your filters.') }}</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($properties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
