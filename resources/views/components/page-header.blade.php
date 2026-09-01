@props([
    'label' => null,
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'mb-8']) }}>
    @if ($label)
        <p class="brand-label">{{ $label }}</p>
    @endif
    <h1 @class(['section-heading', 'mt-2' => $label])>{{ $title }}</h1>
    @if ($description)
        <p class="mt-2 text-ink-700">{{ $description }}</p>
    @endif
</div>
