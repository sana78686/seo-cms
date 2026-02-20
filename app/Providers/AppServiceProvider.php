<?php

namespace App\Providers;

use ArtisanPackUI\SEO\Livewire\HreflangEditor;
use ArtisanPackUI\SEO\Livewire\Partials\MetaPreview;
use ArtisanPackUI\SEO\Livewire\Partials\SocialPreview;
use ArtisanPackUI\SEO\Livewire\RedirectManager;
use ArtisanPackUI\SEO\Livewire\SeoAnalysisPanel;
use ArtisanPackUI\SEO\Livewire\SeoDashboard;
use ArtisanPackUI\SEO\Livewire\SeoMetaEditor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Use published SEO views first (so we can customize the dashboard message)
        if (is_dir(resource_path('views/vendor/seo'))) {
            $this->app['view']->getFinder()->prependNamespace('seo', resource_path('views/vendor/seo'));
        }

        $this->registerSeoLivewireComponents();
    }

    /**
     * Register ArtisanPack UI SEO Livewire components for Livewire 4 compatibility.
     */
    protected function registerSeoLivewireComponents(): void
    {
        $components = [
            'seo::seo-meta-editor' => SeoMetaEditor::class,
            'seo::seo-dashboard' => SeoDashboard::class,
            'seo::seo-analysis-panel' => SeoAnalysisPanel::class,
            'seo::redirect-manager' => RedirectManager::class,
            'seo::hreflang-editor' => HreflangEditor::class,
            'seo::meta-preview' => MetaPreview::class,
            'seo::social-preview' => SocialPreview::class,
        ];

        foreach ($components as $alias => $class) {
            Livewire::component($alias, $class);
            Livewire::component($class); // Also register by class for @livewire(Class::class)
        }

        // Fallback resolver for when alias lookup fails (e.g. cached snapshots)
        Livewire::resolveMissingComponent(function ($name) use ($components) {
            return $components[$name] ?? null;
        });
    }
}
