@extends('layouts.dashboard')

@section('title', 'Create post')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.posts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Posts</a>
        <span class="text-gray-400">/</span>
        <h1 class="text-2xl font-bold text-gray-900">Create post</h1>
    </div>

    <div class="bg-base-100 rounded-lg shadow p-6">
        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.posts.store') }}" method="POST" id="post-form">
            @csrf

            <div class="form-control w-full mb-6">
                <label class="label" for="title">
                    <span class="label-text font-medium">Title</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="input input-bordered w-full" placeholder="Post title" required>
            </div>

            <div class="form-control w-full mb-6">
                <label class="label">
                    <span class="label-text font-medium">Description</span>
                </label>
                <div id="description-editor" class="border border-base-300 rounded-lg overflow-hidden bg-white"></div>
                <input type="hidden" name="content" id="content" value="{{ old('content') }}">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">Create post</button>
                <a href="{{ route('dashboard.posts.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
#description-editor { min-height: 200px; }
#description-editor .ql-editor { min-height: 200px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var quill = new Quill('#description-editor', {
        theme: 'snow',
        placeholder: 'Write your blog content here…',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'blockquote', 'code-block'],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        }
    });

    var contentInput = document.getElementById('content');
    if (contentInput.value) {
        quill.root.innerHTML = contentInput.value;
    }

    document.getElementById('post-form').addEventListener('submit', function () {
        contentInput.value = quill.root.innerHTML;
    });
});
</script>
@endpush
