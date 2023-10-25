<?php

namespace Stew\ImageUploader\Providers;

use Illuminate\Support\ServiceProvider;

class ImageUploaderServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'demo');
        $this->publishes([
            __DIR__ . '/../../database/seeders' => database_path('seeders'),
        ]);
    }
}
