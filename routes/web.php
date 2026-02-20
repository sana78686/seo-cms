<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;

Route::get('/', function () {
    return view('dashboard.index');
});

// Redirect old seo-test to dashboard
Route::redirect('/seo-test', '/dashboard', 302);
Route::get('/seo-test/{post}', function (Post $post) {
    return redirect()->route('dashboard.posts.edit-seo', $post);
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

// Dashboard – Posts
Route::get('/dashboard/posts', function () {
    $posts = Post::with('seoMeta')->latest()->get();
    return view('dashboard.posts.index', compact('posts'));
})->name('dashboard.posts.index');

Route::get('/dashboard/posts/create', function () {
    return view('dashboard.posts.create');
})->name('dashboard.posts.create');

Route::post('/dashboard/posts', function (Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
    ]);
    $post = Post::create($validated);
    return redirect()->route('dashboard.posts.edit-seo', $post)->with('success', 'Blog post created.');
})->name('dashboard.posts.store');

Route::get('/dashboard/posts/{post}', function (Post $post) {
    $post->load('seoMeta');
    return view('dashboard.posts.show', compact('post'));
})->name('dashboard.posts.show');

Route::get('/dashboard/posts/{post}/edit-seo', function (Post $post) {
    $post->load('seoMeta');
    return view('dashboard.posts.edit-seo', compact('post'));
})->name('dashboard.posts.edit-seo');

// Dashboard – Pages
Route::get('/dashboard/pages', function () {
    $pages = Page::with(['seoMeta', 'parent', 'children'])->orderByRaw('parent_id is null desc')->orderBy('title')->get();
    return view('dashboard.pages.index', compact('pages'));
})->name('dashboard.pages.index');

Route::get('/dashboard/pages/create', function () {
    $parentPages = Page::whereNull('parent_id')->orderBy('title')->get();
    return view('dashboard.pages.create', compact('parentPages'));
})->name('dashboard.pages.create');

Route::post('/dashboard/pages', function (Request $request) {
    $validated = $request->validate([
        'parent_id' => 'nullable|exists:pages,id',
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|alpha_dash|unique:pages,slug',
        'content' => 'nullable|string',
    ]);
    $validated['parent_id'] = $validated['parent_id'] ?? null;
    $page = Page::create($validated);
    return redirect()->route('dashboard.pages.edit-seo', $page)->with('success', 'Page created.');
})->name('dashboard.pages.store');

Route::get('/dashboard/pages/{page}/edit', function (Page $page) {
    $page->load('translations');
    $parentPages = Page::whereNull('parent_id')->where('id', '!=', $page->id)->orderBy('title')->get();
    $locales = config('cms.locales', ['en']);
    return view('dashboard.pages.edit', compact('page', 'parentPages', 'locales'));
})->name('dashboard.pages.edit');

Route::put('/dashboard/pages/{page}', function (Request $request, Page $page) {
    $locales = config('cms.locales', ['en']);
    $defaultLocale = config('cms.default_locale', 'en');

    $request->validate([
        'parent_id' => 'nullable|exists:pages,id',
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|alpha_dash|unique:pages,slug,' . $page->id,
        'content' => 'nullable|string',
    ]);

    // Prevent parent being self or descendant
    $parentId = $request->input('parent_id');
    if ($parentId && (int) $parentId === (int) $page->id) {
        return redirect()->back()->withInput()->withErrors(['parent_id' => 'Page cannot be its own parent.']);
    }

    $page->parent_id = $parentId ?: null;
    $page->title = $request->input('title', $page->title);
    $page->slug = $request->input('slug', $page->slug);
    $page->content = $request->input('content', $page->content);
    $page->save();

    foreach ($locales as $locale) {
        if ($locale === $defaultLocale) {
            continue;
        }
        $tTitle = $request->input("translations.{$locale}.title");
        $tSlug = $request->input("translations.{$locale}.slug");
        $tContent = $request->input("translations.{$locale}.content");
        if ($tTitle === null && $tSlug === null && $tContent === null) {
            continue;
        }
        $trans = $page->translations()->firstOrNew(['locale' => $locale]);
        $trans->title = $tTitle ?: $trans->title ?: $page->title;
        $trans->slug = $tSlug ?: $trans->slug ?: $page->slug;
        $trans->content = $tContent !== null ? $tContent : $trans->content;
        $trans->save();
    }

    return redirect()->route('dashboard.pages.index')->with('success', 'Page updated.');
})->name('dashboard.pages.update');

Route::get('/dashboard/pages/{page}', function (Page $page) {
    $page->load('seoMeta');
    return view('dashboard.pages.show', compact('page'));
})->name('dashboard.pages.show');

Route::get('/dashboard/pages/{page}/edit-seo', function (Page $page) {
    $page->load('seoMeta');
    return view('dashboard.pages.edit-seo', compact('page'));
})->name('dashboard.pages.edit-seo');

// Public view – posts (how blog is shown to visitors)
Route::get('/posts/{post}', function (Post $post) {
    $post->load('seoMeta');
    return view('posts.show', compact('post'));
})->name('posts.show');

// Public view – pages (e.g. /pages/contact, /pages/faq)
Route::get('/pages/{page:slug}', function (Page $page) {
    $page->load('seoMeta');
    return view('pages.show', compact('page'));
})->name('pages.show');
