<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/seo-test', '/posts', 302);

Route::get('/posts', function () {
    $posts = Post::with('seoMeta')->latest()->get();
    return view('posts.index', compact('posts'));
});

Route::get('/posts/create', function () {
    return view('posts.create');
})->name('posts.create');

Route::post('/posts', function (Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
    ]);
    $post = Post::create($validated);
    return redirect()->route('seo-test', $post)->with('success', 'Blog post created.');
})->name('posts.store');

Route::get('/posts/{post}', function (Post $post) {
    $post->load('seoMeta');
    return view('posts.show', compact('post'));
})->name('posts.show');

Route::get('/seo-test/{post}', function (Post $post) {
    $post->load('seoMeta');
    return view('seo-test', compact('post'));
})->name('seo-test');
