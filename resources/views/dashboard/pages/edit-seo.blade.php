@extends('layouts.dashboard')

@section('title', 'Edit SEO – ' . $page->title)

@push('head')
@livewireStyles
@endpush

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('dashboard.pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Pages</a>
        <span class="text-gray-400">/</span>
        <a href="{{ route('dashboard.pages.show', $page) }}" class="btn btn-ghost btn-sm">View page</a>
    </div>

    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $page->title }}</h1>
        <p class="text-sm text-gray-500">/pages/{{ $page->slug }}</p>
        <div class="mt-2 text-gray-600 prose prose-gray max-w-none">{!! $page->content !!}</div>
    </div>

    <hr class="border-gray-200">

    <section>
        <h2 class="text-xl font-semibold mb-4">1. SEO Editor</h2>
        <p class="text-sm text-gray-500 mb-2">Edit meta title, description, focus keyword, OG, Twitter, schema for this page.</p>
        @livewire(\ArtisanPackUI\SEO\Livewire\SeoMetaEditor::class, ['model' => $page])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">2. SEO Dashboard</h2>
        @livewire(\ArtisanPackUI\SEO\Livewire\SeoDashboard::class)
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">3. SEO Analysis Panel</h2>
        @livewire(\ArtisanPackUI\SEO\Livewire\SeoAnalysisPanel::class, ['analysis' => []])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">4. Redirect Manager</h2>
        @livewire(\ArtisanPackUI\SEO\Livewire\RedirectManager::class)
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">5. Hreflang Editor</h2>
        @livewire(\ArtisanPackUI\SEO\Livewire\HreflangEditor::class, ['model' => $page])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">6. Meta Preview (SERP)</h2>
        @livewire(\ArtisanPackUI\SEO\Livewire\Partials\MetaPreview::class, [
            'title' => $page->title,
            'description' => \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 160),
            'url' => route('pages.show', $page),
        ])
    </section>

    <section>
        <h2 class="text-xl font-semibold mb-4">7. Social Preview</h2>
        @livewire(\ArtisanPackUI\SEO\Livewire\Partials\SocialPreview::class, [
            'title' => $page->title,
            'description' => \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 155),
            'image' => '',
            'url' => route('pages.show', $page),
        ])
    </section>
</div>

@livewireScripts
@endsection
