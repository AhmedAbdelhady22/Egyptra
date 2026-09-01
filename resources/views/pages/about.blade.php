@extends('layouts.app')

@section('content')
    @php $locale = app()->getLocale(); @endphp

    <div class="brand-container max-w-3xl py-10 md:py-14">
        <x-page-header :label="__('About Egyptra')" :title="$page->getTranslation('title', $locale, false)" />

        <div class="prose-brand mt-8">
            {!! $page->getTranslation('content', $locale, false) !!}
        </div>
    </div>
@endsection
