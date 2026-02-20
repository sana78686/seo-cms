@extends('layouts.dashboard')

@section('title', 'Edit page')
@section('content')
@php
    $defaultLocale = config('cms.default_locale', 'en');
@endphp
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dashboard.pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Pages</a>
        <span class="text-gray-400">/</span>
        <h1 class="text-2xl font-bold text-gray-900">Edit page</h1>
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

        <form action="{{ route('dashboard.pages.update', $page) }}" method="POST" id="page-form">
            @csrf
            @method('PUT')

            <div class="form-control w-full mb-6">
                <label class="label" for="parent_id">
                    <span class="label-text font-medium">Parent page</span>
                </label>
                <select name="parent_id" id="parent_id" class="select select-bordered w-full">
                    <option value="">— None (main navigation)</option>
                    @foreach($parentPages as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $page->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tabs per locale --}}
            <div class="tabs tabs-boxed mb-4">
                @foreach($locales as $locale)
                    <button type="button" class="tab locale-tab {{ $loop->first ? 'tab-active' : '' }}" data-locale="{{ $locale }}">
                        {{ strtoupper($locale) }}
                    </button>
                @endforeach
            </div>

            @foreach($locales as $locale)
                @php
                    $isDefault = $locale === $defaultLocale;
                    $trans = $page->translations->firstWhere('locale', $locale);
                @endphp
                <div class="locale-panel {{ $locale !== $defaultLocale ? 'hidden' : '' }}" data-locale="{{ $locale }}">
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-medium">Title ({{ $locale }})</span></label>
                        <input type="text"
                               name="{{ $isDefault ? 'title' : "translations[{$locale}][title]" }}"
                               value="{{ old($isDefault ? 'title' : "translations.{$locale}.title", $isDefault ? $page->title : (optional($trans)->title ?? '')) }}"
                               class="input input-bordered w-full" {{ $isDefault ? 'required' : '' }}>
                    </div>
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-medium">URL slug ({{ $locale }})</span></label>
                        <input type="text"
                               name="{{ $isDefault ? 'slug' : "translations[{$locale}][slug]" }}"
                               value="{{ old($isDefault ? 'slug' : "translations.{$locale}.slug", $isDefault ? $page->slug : (optional($trans)->slug ?? '')) }}"
                               class="input input-bordered w-full" {{ $isDefault ? 'required' : '' }}>
                    </div>
                    <div class="form-control w-full mb-6">
                        <label class="label"><span class="label-text font-medium">Content ({{ $locale }})</span></label>
                        <div class="content-editor border border-base-300 rounded-lg overflow-hidden bg-white" data-locale="{{ $locale }}" style="min-height: 200px;"></div>
                        <input type="hidden" name="{{ $isDefault ? 'content' : "translations[{$locale}][content]" }}" id="content-{{ $locale }}" value="{{ old($isDefault ? 'content' : "translations.{$locale}.content", $isDefault ? ($page->content ?? '') : (optional($trans)->content ?? '')) }}">
                    </div>
                </div>
            @endforeach

            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary">Update page</button>
                <a href="{{ route('dashboard.pages.index') }}" class="btn btn-ghost">Cancel</a>
                <a href="{{ route('dashboard.pages.edit-seo', $page) }}" class="btn btn-ghost btn-sm ml-auto">Edit SEO</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
.content-editor .ql-editor { min-height: 180px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var editors = {};
    var defaultLocale = @json(config('cms.default_locale', 'en'));
    var locales = @json($locales);

    document.querySelectorAll('.content-editor').forEach(function (el) {
        var locale = el.dataset.locale;
        var quill = new Quill(el, {
            theme: 'snow',
            placeholder: 'Content for ' + locale + '…',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote', 'code-block'],
                    ['clean']
                ]
            }
        });
        var input = document.getElementById('content-' + locale);
        if (input && input.value) {
            quill.root.innerHTML = input.value;
        }
        editors[locale] = quill;
    });

    document.querySelectorAll('.locale-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            var locale = this.dataset.locale;
            document.querySelectorAll('.locale-tab').forEach(function (t) { t.classList.remove('tab-active'); });
            this.classList.add('tab-active');
            document.querySelectorAll('.locale-panel').forEach(function (p) {
                p.classList.toggle('hidden', p.dataset.locale !== locale);
            });
        });
    });

    document.getElementById('page-form').addEventListener('submit', function () {
        locales.forEach(function (locale) {
            var input = document.getElementById('content-' + locale);
            if (input && editors[locale]) {
                input.value = editors[locale].root.innerHTML;
            }
        });
    });
});
</script>
@endpush
