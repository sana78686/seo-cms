<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/seo-test', '/posts', 302);

Route::get('/posts', function () {
    $posts = Post::with('seoMeta')->latest()->get();
    return view('posts.index', compact('posts'));
});

Route::get('/seo-test/{post}', function (Post $post) {
    $post->load('seoMeta');
    return view('seo-test', compact('post'));
})->name('seo-test');
