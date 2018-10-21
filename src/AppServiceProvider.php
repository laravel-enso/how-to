<?php

namespace LaravelEnso\HowToVideos;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadDependencies()
            ->publishDependencies();
    }

    public function loadDependencies()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        return $this;
    }

    public function publishDependencies()
    {
        $this->publishes([
            __DIR__.'/storage/app' => storage_path('app'),
        ], 'howToVideos-storage');

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'howToVideos-assets');

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'enso-assets');
    }

    public function register()
    {
        //
    }
}
