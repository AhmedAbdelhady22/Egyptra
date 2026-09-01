@extends('layouts.app')

@section('content')
    @php $locale = app()->getLocale(); @endphp

    <div class="brand-container py-10 md:py-14">
        <x-page-header
            :label="__('Insights')"
            :title="__('Blog')"
            :description="__('Insights, updates, and market news.')"
        />

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article class="card-brand">
                    @if ($post->featured_image)
                        <img src="{{ asset('storage/'.$post->featured_image) }}" alt="" class="aspect-video w-full object-cover">
                    @endif
                    <div class="p-5">
                        @if ($post->published_at)
                            <time datetime="{{ $post->published_at->toDateString() }}" class="font-mono text-xs text-ash">{{ $post->published_at->format('M d, Y') }}</time>
                        @endif
                        <h2 class="mt-2 font-display text-lg text-ink">
                            <a href="{{ route('blog.show', ['locale' => $locale, 'post' => $post->localizedSlug()]) }}" class="hover:text-teal">
                                {{ $post->getTranslation('title', $locale, false) }}
                            </a>
                        </h2>
                        <p class="mt-2 line-clamp-3 text-sm text-ink-700">{{ \Illuminate\Support\Str::limit(strip_tags($post->getTranslation('content', $locale, false)), 140) }}</p>
                    </div>
                </article>
            @empty
                <p class="text-ink-700">{{ __('No articles published yet.') }}</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
