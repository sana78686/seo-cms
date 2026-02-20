<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-seo:meta :model="$post" />

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-base-200 p-4 md:p-8">

<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between gap-4 mb-6">
        <a href="{{ url('/posts') }}" class="text-sm text-gray-600 hover:text-gray-900">← All posts</a>
        <a href="{{ route('seo-test', $post) }}" class="text-sm text-gray-600 hover:text-gray-900">Edit SEO</a>
    </div>

    <article class="bg-base-100 rounded-lg shadow p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
        <div class="mt-4 text-gray-700 prose prose-gray max-w-none">{!! $post->content !!}</div>
    </article>
</div>

</body>
</html>
