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
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([
            __DIR__ . '/../../database/seeders' => database_path('seeders'),
        ]);
    }
}
