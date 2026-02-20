@extends('layouts.dashboard')

@section('title', 'Create page')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Pages</a>
        <span class="text-gray-400">/</span>
        <h1 class="text-2xl font-bold text-gray-900">Create page</h1>
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

        <form action="{{ route('dashboard.pages.store') }}" method="POST" id="page-form">
            @csrf

            <div class="form-control w-full mb-6">
                <label class="label" for="parent_id">
                    <span class="label-text font-medium">Parent page</span>
                </label>
                <select name="parent_id" id="parent_id" class="select select-bordered w-full">
                    <option value="">— None (show on main navigation)</option>
                    @foreach($parentPages as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                    @endforeach
                </select>
                <label class="label">
                    <span class="label-text-alt">Leave empty for main nav; select a parent to show under its dropdown.</span>
                </label>
            </div>

            <div class="form-control w-full mb-6">
                <label class="label" for="title">
                    <span class="label-text font-medium">Title</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="input input-bordered w-full" placeholder="e.g. Contact Us" required>
            </div>

            <div class="form-control w-full mb-6">
                <label class="label" for="slug">
                    <span class="label-text font-medium">URL slug</span>
                </label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                       class="input input-bordered w-full" placeholder="e.g. contact or faq" required>
                <label class="label">
                    <span class="label-text-alt">Page URL will be: /pages/<span id="slug-preview" class="font-medium">{{ old('slug', 'slug') }}</span></span>
                </label>
            </div>

            <div class="form-control w-full mb-6">
                <label class="label">
                    <span class="label-text font-medium">Content</span>
                </label>
                <div id="content-editor" class="border border-base-300 rounded-lg overflow-hidden bg-white"></div>
                <input type="hidden" name="content" id="content" value="{{ old('content') }}">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">Create page</button>
                <a href="{{ route('dashboard.pages.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
#content-editor { min-height: 200px; }
#content-editor .ql-editor { min-height: 200px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var quill = new Quill('#content-editor', {
        theme: 'snow',
        placeholder: 'Write page content here…',
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

    document.getElementById('page-form').addEventListener('submit', function () {
        contentInput.value = quill.root.innerHTML;
    });

    // Slug preview
    var slugInput = document.getElementById('slug');
    var slugPreview = document.getElementById('slug-preview');
    function updateSlugPreview() {
        var val = slugInput.value.trim().toLowerCase().replace(/[^a-z0-9-]/g, '-').replace(/-+/g, '-') || 'slug';
        slugPreview.textContent = val;
    }
    slugInput.addEventListener('input', updateSlugPreview);
    updateSlugPreview();
});
</script>
@endpush
