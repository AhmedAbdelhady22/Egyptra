@extends('layouts.app')

@section('content')
    <div class="mx-auto flex min-h-[50vh] max-w-2xl flex-col items-center justify-center px-4 py-16 text-center">
        <x-brand-logo size="xl" :show-name="false" href="{{ route('home', ['locale' => app()->getLocale() ?: 'en']) }}" class="mb-6" />
        <p class="brand-label">403</p>
        <h1 class="section-heading mt-3">{{ __('Access denied') }}</h1>
        <p class="mt-3 text-ink-700">{{ __('You do not have permission to view this page.') }}</p>
        <a href="{{ route('home', ['locale' => app()->getLocale() ?: 'en']) }}" class="btn-primary mt-8">
            {{ __('Back to Home') }}
        </a>
    </div>
@endsection
