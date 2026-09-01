@props(['video'])

@php
    use App\Enums\VideoType;
@endphp

@if ($video->type === VideoType::Url && $video->url)
    @php
        $embedUrl = $video->url;
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $video->url, $matches)) {
            $embedUrl = 'https://www.youtube.com/embed/'.$matches[1];
        } elseif (str_contains($video->url, 'vimeo.com')) {
            $embedUrl = str_replace('vimeo.com', 'player.vimeo.com/video', preg_replace('/\/(\d+).*/', '/$1', $video->url));
        }
    @endphp
    <div class="aspect-video overflow-hidden rounded-sm bg-ink">
        <iframe src="{{ $embedUrl }}" class="h-full w-full" allowfullscreen loading="lazy" title="{{ __('Property video') }}"></iframe>
    </div>
@elseif ($video->type === VideoType::File && $video->path)
    <video controls class="aspect-video w-full rounded-sm bg-ink" preload="metadata">
        <source src="{{ asset('storage/'.$video->path) }}">
    </video>
@endif
