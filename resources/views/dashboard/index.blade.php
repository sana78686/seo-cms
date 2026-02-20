@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Dashboard</h1>
    <p class="text-gray-600 mb-8">Choose a module to manage content and SEO.</p>

    <div class="grid gap-6 md:grid-cols-2">
        <a href="{{ route('dashboard.posts.index') }}" class="card bg-base-100 shadow hover:shadow-md transition-shadow">
            <div class="card-body">
                <h2 class="card-title text-xl">Posts</h2>
                <p class="text-gray-600">Manage blog posts: create, view, and edit SEO.</p>
                <div class="card-actions justify-end mt-4">
                    <span class="btn btn-primary btn-sm">Manage posts →</span>
                </div>
            </div>
        </a>

        <a href="{{ route('dashboard.pages.index') }}" class="card bg-base-100 shadow hover:shadow-md transition-shadow">
            <div class="card-body">
                <h2 class="card-title text-xl">Pages</h2>
                <p class="text-gray-600">Manage website pages (Contact, FAQ, etc.): create, view, and edit SEO.</p>
                <div class="card-actions justify-end mt-4">
                    <span class="btn btn-primary btn-sm">Manage pages →</span>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
