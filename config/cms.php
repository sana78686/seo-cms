<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Supported locales for pages
    |--------------------------------------------------------------------------
    */
    'locales' => array_filter(explode(',', env('APP_LOCALES', 'en'))),

    /*
    |--------------------------------------------------------------------------
    | Default locale (stored in pages.title, slug, content)
    |--------------------------------------------------------------------------
    */
    'default_locale' => env('APP_LOCALE', config('app.locale', 'en')),

];
