<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create blog post – {{ config('app.name') }}</title>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        #description-editor { min-height: 200px; }
        #description-editor .ql-editor { min-height: 200px; }
    </style>
</head>
<body class="min-h-screen bg-base-200 p-4 md:p-8">

<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ url('/posts') }}" class="text-sm text-gray-600 hover:text-gray-900">← All posts</a>
    </div>

    <div class="bg-base-100 rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Create blog post</h1>

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

        <form action="{{ route('posts.store') }}" method="POST" id="post-form">
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
                <a href="{{ url('/posts') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>

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
</body>
</html>
