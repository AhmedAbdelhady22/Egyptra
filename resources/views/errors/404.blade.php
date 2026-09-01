@extends('layouts.app')

@section('content')
    <div class="mx-auto flex min-h-[50vh] max-w-2xl flex-col items-center justify-center px-4 py-16 text-center">
        <x-brand-logo size="xl" :show-name="false" href="{{ route('home', ['locale' => app()->getLocale() ?: 'en']) }}" class="mb-6" />
        <p class="brand-label">404</p>
        <h1 class="section-heading mt-3">{{ __('Page not found') }}</h1>
        <p class="mt-3 text-ink-700">{{ __('The page you are looking for does not exist or has been moved.') }}</p>
        <a href="{{ route('home', ['locale' => app()->getLocale() ?: 'en']) }}" class="btn-primary mt-8">
            {{ __('Back to Home') }}
        </a>
    </div>
@endsection
