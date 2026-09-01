@props([
    'propertyTypes',
    'cities',
    'areas',
    'compounds',
    'listingTypes',
    'furnishedTypes',
    'statuses',
])

<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="brand-label text-ash">{{ __('Filters') }}</h2>
        <button type="button" wire:click="clearFilters" class="text-xs font-medium text-ink-700 hover:text-teal">
            {{ __('Clear') }}
        </button>
    </div>

    <div>
        <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Listing Type') }}</label>
        <select wire:model.live="listingType" class="input-brand">
            <option value="">{{ __('All') }}</option>
            @foreach ($listingTypes as $type)
                <option value="{{ $type->value }}">{{ $type->label() }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Property Type') }}</label>
        <select wire:model.live="propertyTypeId" class="input-brand">
            <option value="">{{ __('All') }}</option>
            @foreach ($propertyTypes as $type)
                <option value="{{ $type->id }}">{{ $type->getTranslation('name', app()->getLocale(), false) }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('City') }}</label>
        <select wire:model.live="cityId" class="input-brand">
            <option value="">{{ __('All') }}</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->getTranslation('name', app()->getLocale(), false) }}</option>
            @endforeach
        </select>
    </div>

    @if ($areas->isNotEmpty())
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Area') }}</label>
            <select wire:model.live="areaId" class="input-brand">
                <option value="">{{ __('All') }}</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->getTranslation('name', app()->getLocale(), false) }}</option>
                @endforeach
            </select>
        </div>
    @endif

    @if ($compounds->isNotEmpty())
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Compound') }}</label>
            <select wire:model.live="compoundId" class="input-brand">
                <option value="">{{ __('All') }}</option>
                @foreach ($compounds as $compound)
                    <option value="{{ $compound->id }}">{{ $compound->getTranslation('name', app()->getLocale(), false) }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Min Price') }}</label>
            <input type="number" wire:model.live.debounce.500ms="priceMin" class="input-brand">
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Max Price') }}</label>
            <input type="number" wire:model.live.debounce.500ms="priceMax" class="input-brand">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Min Area') }}</label>
            <input type="number" wire:model.live.debounce.500ms="areaMin" class="input-brand">
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Max Area') }}</label>
            <input type="number" wire:model.live.debounce.500ms="areaMax" class="input-brand">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Bedrooms') }}</label>
            <input type="number" wire:model.live="bedrooms" min="0" class="input-brand">
        </div>
        <div>
            <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Bathrooms') }}</label>
            <input type="number" wire:model.live="bathrooms" min="0" class="input-brand">
        </div>
    </div>

    <div>
        <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Floor') }}</label>
        <input type="text" wire:model.live.debounce.500ms="floor" class="input-brand" placeholder="{{ __('e.g. 3, Ground') }}">
    </div>

    <div>
        <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Furnished') }}</label>
        <select wire:model.live="furnished" class="input-brand">
            <option value="">{{ __('All') }}</option>
            @foreach ($furnishedTypes as $type)
                <option value="{{ $type->value }}">{{ $type->label() }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block font-mono text-[11px] uppercase tracking-wider text-teal">{{ __('Status') }}</label>
        <select wire:model.live="status" class="input-brand">
            <option value="">{{ __('All') }}</option>
            @foreach ($statuses as $item)
                <option value="{{ $item->value }}">{{ $item->label() }}</option>
            @endforeach
        </select>
    </div>
</div>
