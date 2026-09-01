@props([
    'items' => [],
])

@php
    $lastIndex = count($items) - 1;
@endphp

<nav {{ $attributes->merge(['class' => 'mb-6 text-sm text-ash']) }} aria-label="{{ __('Breadcrumb') }}">
    @foreach ($items as $index => $item)
        @if ($index > 0)
            <span class="mx-2" aria-hidden="true">/</span>
        @endif

        @if ($index === $lastIndex || empty($item['url']))
            <span class="text-ink">{{ $item['label'] }}</span>
        @else
            <a href="{{ $item['url'] }}" class="transition hover:text-teal">{{ $item['label'] }}</a>
        @endif
    @endforeach
</nav>
