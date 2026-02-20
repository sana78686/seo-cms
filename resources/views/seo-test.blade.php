<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <x-seo:meta :model="$post" />

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>
<body class="min-h-screen bg-base-200 p-4 md:p-8">

<div class="max-w-6xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ url('/posts') }}" class="text-sm text-gray-600 hover:text-gray-900">← All posts</a>
        <a href="{{ route('posts.show', $post) }}" class="btn btn-ghost btn-sm">View post</a>
    </div>
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
        <div class="mt-2 text-gray-600 prose prose-gray max-w-none">{!! $post->content !!}</div>
    </div>

    <hr class="border-gray-200">

    <section>
        <h2 class="text-xl font-semibold mb-4">1. SEO Editor</h2>
        <p class="text-sm text-gray-500 mb-2">Edit meta title, description, focus keyword, OG, Twitter, schema for this post.</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\SeoMetaEditor::class, ['model' => $post])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">2. SEO Dashboard</h2>
        <p class="text-sm text-gray-500 mb-2">Site-wide SEO performance (Search Console). Shows message if analytics not configured.</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\SeoDashboard::class)
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">3. SEO Analysis Panel</h2>
        <p class="text-sm text-gray-500 mb-2">Shows analysis score and issues. Pass analysis data from your analyzer.</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\SeoAnalysisPanel::class, ['analysis' => []])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">4. Redirect Manager</h2>
        <p class="text-sm text-gray-500 mb-2">CRUD for URL redirects (301, 302, etc.).</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\RedirectManager::class)
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">5. Hreflang Editor</h2>
        <p class="text-sm text-gray-500 mb-2">Manage alternate language URLs for this post.</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\HreflangEditor::class, ['model' => $post])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">6. Meta Preview (SERP)</h2>
        <p class="text-sm text-gray-500 mb-2">Preview how the page looks in Google search.</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\Partials\MetaPreview::class, [
            'title' => $post->title,
            'description' => \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 160),
            'url' => url()->current(),
        ])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">7. Social Preview</h2>
        <p class="text-sm text-gray-500 mb-2">Preview how the page looks when shared on Facebook/Twitter.</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\Partials\SocialPreview::class, [
            'title' => $post->title,
            'description' => \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 155),
            'image' => '',
            'url' => url()->current(),
        ])
    </section>
</div>

@livewireScripts
</body>
</html>
