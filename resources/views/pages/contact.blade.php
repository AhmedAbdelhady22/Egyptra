@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $general = app(\App\Settings\GeneralSettings::class);
    @endphp

    <div class="brand-container py-10 md:py-14">
        <div class="grid gap-10 lg:grid-cols-2">
            <div>
                <x-page-header
                    :label="__('Get in touch')"
                    :title="__('Contact Us')"
                    :description="__('We would love to hear from you. Send us a message and our team will respond promptly.')"
                />

                <dl class="mt-8 space-y-4 text-sm text-ink-700">
                    @if ($general->phone)
                        <div>
                            <dt class="font-medium text-ink">{{ __('Phone') }}</dt>
                            <dd>{{ $general->phone }}</dd>
                        </div>
                    @endif
                    @if ($general->email)
                        <div>
                            <dt class="font-medium text-ink">{{ __('Email') }}</dt>
                            <dd>{{ $general->email }}</dd>
                        </div>
                    @endif
                    @if ($general->address)
                        <div>
                            <dt class="font-medium text-ink">{{ __('Address') }}</dt>
                            <dd>{{ $general->address }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="border border-lavender-200 bg-lavender-50 p-6 sm:p-8">
                <livewire:contact-form />
            </div>
        </div>
    </div>
@endsection
