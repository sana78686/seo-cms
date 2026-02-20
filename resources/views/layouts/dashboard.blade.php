<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') – {{ config('app.name') }}</title>
    @stack('styles')
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @stack('head')
</head>
<body class="min-h-screen bg-base-200">
    <div class="navbar bg-base-100 shadow-sm">
        <div class="flex-1">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost text-xl">Dashboard</a>
        </div>
        <div class="flex-none gap-2">
            <a href="{{ route('dashboard.posts.index') }}" class="btn btn-ghost btn-sm">Posts</a>
            <a href="{{ route('dashboard.pages.index') }}" class="btn btn-ghost btn-sm">Pages</a>
        </div>
    </div>

    <main class="p-4 md:p-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
