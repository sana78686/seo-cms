<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Page;

/*
|--------------------------------------------------------------------------
| API for Vue.js frontend
|--------------------------------------------------------------------------
|
| Navigation: parents on main bar, children in dropdown.
| Pages are multi-language; pass ?locale= to get translated content.
|
*/

/**
 * GET /api/pages/navigation?locale=en
 *
 * Returns tree for nav: parents (main bar) with children (dropdown).
 * Each item: id, title, slug, url, children (for parents).
 */
Route::get('/pages/navigation', function (Request $request) {
    $locale = $request->input('locale', config('cms.default_locale', config('app.locale', 'en')));
    $baseUrl = rtrim(config('app.url'), '/');

    $parents = Page::with(['children' => function ($q) {
        $q->with('translations')->orderBy('title');
    }, 'translations'])->whereNull('parent_id')->orderBy('title')->get();

    $tree = $parents->map(function (Page $page) use ($locale, $baseUrl) {
        $slug = $page->getSlugForLocale($locale);
        $item = [
            'id' => $page->id,
            'title' => $page->getTitleForLocale($locale),
            'slug' => $slug,
            'url' => $baseUrl . '/pages/' . $slug,
            'children' => [],
        ];
        foreach ($page->children as $child) {
            $childSlug = $child->getSlugForLocale($locale);
            $item['children'][] = [
                'id' => $child->id,
                'title' => $child->getTitleForLocale($locale),
                'slug' => $childSlug,
                'url' => $baseUrl . '/pages/' . $childSlug,
            ];
        }
        return $item;
    });

    return response()->json([
        'locale' => $locale,
        'navigation' => $tree,
    ]);
});

/**
 * GET /api/pages/{slug}?locale=en
 *
 * Returns single page content by slug for the given locale.
 * Vue frontend can use this to render the page.
 */
Route::get('/pages/{slug}', function (Request $request, string $slug) {
    $locale = $request->input('locale', config('cms.default_locale', config('app.locale', 'en')));
    $defaultLocale = config('cms.default_locale', config('app.locale', 'en'));

    $page = Page::with('translations')->where('slug', $slug)->first();
    if (!$page) {
        $trans = \App\Models\PageTranslation::where('slug', $slug)->where('locale', $locale)->with('page.translations')->first();
        if ($trans) {
            $page = $trans->page;
            $page->load('translations');
        }
    }
    if (!$page) {
        return response()->json(['message' => 'Page not found'], 404);
    }

    return response()->json([
        'id' => $page->id,
        'locale' => $locale,
        'title' => $page->getTitleForLocale($locale),
        'slug' => $page->getSlugForLocale($locale),
        'content' => $page->getContentForLocale($locale),
        'parent_id' => $page->parent_id,
        'url' => rtrim(config('app.url'), '/') . '/pages/' . $page->getSlugForLocale($locale),
    ]);
});
