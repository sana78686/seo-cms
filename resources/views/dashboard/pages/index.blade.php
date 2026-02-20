@extends('layouts.dashboard')

@section('title', 'Pages')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">← Dashboard</a>
            <span class="text-gray-400">/</span>
            <h1 class="text-2xl font-bold text-gray-900">Pages</h1>
        </div>
        <a href="{{ route('dashboard.pages.create') }}" class="btn btn-primary">Create page</a>
    </div>

    @if($pages->isEmpty())
        <div class="bg-base-100 rounded-lg shadow p-6 text-center text-gray-500">
            No pages yet. <a href="{{ route('dashboard.pages.create') }}" class="link link-primary">Create one</a> (e.g. Contact, FAQ).
        </div>
    @else
        <ul class="space-y-4">
            @foreach($pages as $page)
                <li class="bg-base-100 rounded-lg shadow p-4 flex flex-wrap items-center justify-between gap-4 {{ $page->parent_id ? 'ml-6 border-l-2 border-base-300 pl-4' : '' }}">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-lg font-semibold text-gray-900 truncate">{{ $page->title }}</h2>
                            @if($page->parent_id)
                                <span class="badge badge-ghost badge-sm">Child of {{ $page->parent->title ?? '—' }}</span>
                            @else
                                <span class="badge badge-primary badge-sm">Main nav</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500">/{{ $page->slug }}</p>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 120) }}</p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('dashboard.pages.show', $page) }}" class="btn btn-ghost btn-sm">View</a>
                        <a href="{{ route('dashboard.pages.edit', $page) }}" class="btn btn-ghost btn-sm">Edit</a>
                        <a href="{{ route('dashboard.pages.edit-seo', $page) }}" class="btn btn-primary btn-sm">Edit SEO</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
