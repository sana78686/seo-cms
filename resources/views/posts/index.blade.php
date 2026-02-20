<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts – {{ config('app.name') }}</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-base-200 p-4 md:p-8">

<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">All Posts</h1>

    @if($posts->isEmpty())
        <div class="bg-base-100 rounded-lg shadow p-6 text-center text-gray-500">
            No posts yet.
        </div>
    @else
        <ul class="space-y-4">
            @foreach($posts as $post)
                <li class="bg-base-100 rounded-lg shadow p-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-lg font-semibold text-gray-900 truncate">{{ $post->title ?: 'Untitled' }}</h2>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 120) }}</p>
                    </div>
                    <a href="{{ route('seo-test', $post) }}" class="btn btn-primary btn-sm shrink-0">
                        Edit SEO
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

</body>
</html>
