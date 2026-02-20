@extends('layouts.dashboard')

@section('title', 'Posts')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">← Dashboard</a>
            <span class="text-gray-400">/</span>
            <h1 class="text-2xl font-bold text-gray-900">Posts</h1>
        </div>
        <a href="{{ route('dashboard.posts.create') }}" class="btn btn-primary">Create post</a>
    </div>

    @if($posts->isEmpty())
        <div class="bg-base-100 rounded-lg shadow p-6 text-center text-gray-500">
            No posts yet. <a href="{{ route('dashboard.posts.create') }}" class="link link-primary">Create one</a>.
        </div>
    @else
        <ul class="space-y-4">
            @foreach($posts as $post)
                <li class="bg-base-100 rounded-lg shadow p-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-lg font-semibold text-gray-900 truncate">{{ $post->title ?: 'Untitled' }}</h2>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 120) }}</p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('dashboard.posts.show', $post) }}" class="btn btn-ghost btn-sm">View post</a>
                        <a href="{{ route('dashboard.posts.edit-seo', $post) }}" class="btn btn-primary btn-sm">Edit SEO</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
