<?php

namespace App\Livewire;

use App\Enums\FurnishedType;
use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Models\Area;
use App\Models\City;
use App\Models\Compound;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyListing extends Component
{
    use WithPagination;

    #[Url(as: 'listing_type')]
    public ?string $listingType = null;

    #[Url(as: 'property_type')]
    public ?int $propertyTypeId = null;

    #[Url(as: 'city')]
    public ?int $cityId = null;

    #[Url(as: 'area')]
    public ?int $areaId = null;

    #[Url(as: 'compound')]
    public ?int $compoundId = null;

    #[Url(as: 'price_min')]
    public ?string $priceMin = null;

    #[Url(as: 'price_max')]
    public ?string $priceMax = null;

    #[Url(as: 'area_min')]
    public ?string $areaMin = null;

    #[Url(as: 'area_max')]
    public ?string $areaMax = null;

    #[Url(as: 'bedrooms')]
    public ?int $bedrooms = null;

    #[Url(as: 'bathrooms')]
    public ?int $bathrooms = null;

    #[Url(as: 'floor')]
    public ?string $floor = null;

    #[Url(as: 'furnished')]
    public ?string $furnished = null;

    #[Url(as: 'status')]
    public ?string $status = null;

    #[Url(as: 'sort')]
    public string $sort = 'newest';

    public function updatedCityId(): void
    {
        $this->areaId = null;
        $this->compoundId = null;
        $this->resetPage();
    }

    public function updatedAreaId(): void
    {
        $this->compoundId = null;
        $this->resetPage();
    }

    public function updated($property): void
    {
        if ($property !== 'sort') {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset([
            'listingType',
            'propertyTypeId',
            'cityId',
            'areaId',
            'compoundId',
            'priceMin',
            'priceMax',
            'areaMin',
            'areaMax',
            'bedrooms',
            'bathrooms',
            'floor',
            'furnished',
            'status',
            'sort',
        ]);

        $this->sort = 'newest';
        $this->resetPage();
    }

    /**
     * @return array<string, mixed>
     */
    protected function filters(): array
    {
        return array_filter([
            'listing_type' => $this->listingType,
            'property_type_id' => $this->propertyTypeId,
            'city_id' => $this->cityId,
            'area_id' => $this->areaId,
            'compound_id' => $this->compoundId,
            'price_min' => $this->priceMin,
            'price_max' => $this->priceMax,
            'area_min' => $this->areaMin,
            'area_max' => $this->areaMax,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'floor' => $this->floor,
            'furnished' => $this->furnished,
            'status' => $this->status,
        ], fn (mixed $value) => $value !== null && $value !== '');
    }

    public function render(): View
    {
        $properties = Property::query()
            ->published()
            ->filter($this->filters())
            ->with(['propertyType', 'city', 'area', 'images'])
            ->when($this->sort === 'price_asc', fn ($query) => $query->orderBy('price'))
            ->when($this->sort === 'price_desc', fn ($query) => $query->orderByDesc('price'))
            ->when($this->sort === 'area_asc', fn ($query) => $query->orderBy('property_area_sqm'))
            ->when($this->sort === 'area_desc', fn ($query) => $query->orderByDesc('property_area_sqm'))
            ->when($this->sort === 'newest', fn ($query) => $query->latest('published_at'))
            ->when($this->sort === 'oldest', fn ($query) => $query->oldest('published_at'))
            ->paginate(12);

        return view('pages.properties.index', [
            'properties' => $properties,
            'propertyTypes' => PropertyType::query()->active()->ordered()->get(),
            'cities' => City::query()->active()->ordered()->get(),
            'areas' => $this->cityId
                ? Area::query()->active()->ordered()->where('city_id', $this->cityId)->get()
                : collect(),
            'compounds' => $this->areaId
                ? Compound::query()->active()->ordered()->where('area_id', $this->areaId)->get()
                : collect(),
            'listingTypes' => ListingType::cases(),
            'furnishedTypes' => FurnishedType::cases(),
            'statuses' => PropertyStatus::cases(),
            'sortOptions' => [
                'newest' => __('Newest'),
                'oldest' => __('Oldest'),
                'price_asc' => __('Price: Low to High'),
                'price_desc' => __('Price: High to Low'),
                'area_asc' => __('Area: Small to Large'),
                'area_desc' => __('Area: Large to Small'),
            ],
        ])->layout('layouts.app', [
            'seoTitle' => __('Properties'),
            'seoDescription' => __('Browse available properties for sale and rent.'),
        ]);
    }
}
