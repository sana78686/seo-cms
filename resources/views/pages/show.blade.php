<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-seo:meta :model="$page" />

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-base-200 p-4 md:p-8">

<div class="max-w-3xl mx-auto">
    <article class="bg-base-100 rounded-lg shadow p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
        <div class="mt-4 text-gray-700 prose prose-gray max-w-none">{!! $page->content !!}</div>
    </article>
</div>

</body>
</html>
