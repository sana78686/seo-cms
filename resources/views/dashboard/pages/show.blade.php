@extends('layouts.dashboard')

@section('title', $page->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Pages</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-700">View</span>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pages.show', $page) }}" class="btn btn-ghost btn-sm" target="_blank">Open public page</a>
            <a href="{{ route('dashboard.pages.edit', $page) }}" class="btn btn-ghost btn-sm">Edit</a>
            <a href="{{ route('dashboard.pages.edit-seo', $page) }}" class="btn btn-primary btn-sm">Edit SEO</a>
        </div>
    </div>

    <article class="bg-base-100 rounded-lg shadow p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
        <p class="text-sm text-gray-500 mt-1">/pages/{{ $page->slug }}</p>
        <div class="mt-4 text-gray-700 prose prose-gray max-w-none">{!! $page->content !!}</div>
    </article>
</div>
@endsection
