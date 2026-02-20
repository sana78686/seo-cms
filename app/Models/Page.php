<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ArtisanPackUI\SEO\Traits\HasSeo;

class Page extends Model
{
    use HasSeo;

    protected $fillable = ['parent_id', 'title', 'slug', 'content'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('title');
    }

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    /**
     * Get title for locale (from translation or fallback to default).
     */
    public function getTitleForLocale(string $locale): string
    {
        $defaultLocale = config('cms.default_locale', config('app.locale', 'en'));
        if ($locale === $defaultLocale) {
            return $this->title ?? '';
        }
        $t = $this->translations->firstWhere('locale', $locale);
        return $t ? $t->title : ($this->title ?? '');
    }

    /**
     * Get slug for locale.
     */
    public function getSlugForLocale(string $locale): string
    {
        $defaultLocale = config('cms.default_locale', config('app.locale', 'en'));
        if ($locale === $defaultLocale) {
            return $this->slug ?? '';
        }
        $t = $this->translations->firstWhere('locale', $locale);
        return $t ? $t->slug : ($this->slug ?? '');
    }

    /**
     * Get content for locale.
     */
    public function getContentForLocale(string $locale): ?string
    {
        $defaultLocale = config('cms.default_locale', config('app.locale', 'en'));
        if ($locale === $defaultLocale) {
            return $this->content;
        }
        $t = $this->translations->firstWhere('locale', $locale);
        return $t ? $t->content : $this->content;
    }

    /**
     * Whether this page is a parent (shown on main nav).
     */
    public function isParent(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Whether this page is a child (shown under parent dropdown).
     */
    public function isChild(): bool
    {
        return $this->parent_id !== null;
    }
}
