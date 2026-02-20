@extends('layouts.dashboard')

@section('title', $post->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.posts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Posts</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-700">View</span>
        </div>
        <div class="flex gap-2">
            <a href="{{ url('/posts/' . $post->id) }}" class="btn btn-ghost btn-sm" target="_blank">Open public page</a>
            <a href="{{ route('dashboard.posts.edit-seo', $post) }}" class="btn btn-primary btn-sm">Edit SEO</a>
        </div>
    </div>

    <article class="bg-base-100 rounded-lg shadow p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
        <div class="mt-4 text-gray-700 prose prose-gray max-w-none">{!! $post->content !!}</div>
    </article>
</div>
@endsection
