<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ArtisanPackUI\SEO\Traits\HasSeo;

class Post extends Model
{
    use HasSeo;

    protected $fillable = ['title', 'content'];

    // seoMeta() is provided by HasSeo trait - morphOne SeoMeta
}
