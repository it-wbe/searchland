<?php

namespace Wbe\Searchland;

use Illuminate\Support\ServiceProvider;

class SearchlandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // load routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'searchland');
//        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->publishes([
            __DIR__ . '/../config/search.php' => config_path('search.php'),

        ], 'config');
        $this->publishes([
            __DIR__ . '/../public/assets' => public_path('packages/wbe/searchland/assets'),
        ], 'public');

        $this->app['view']->addNamespace('searchland', base_path() . '/vendor/wbe/searchland/views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
