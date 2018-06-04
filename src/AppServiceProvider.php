<?php

namespace LaravelEnso\HowToVideos;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadDependencies();
        $this->setPublishes();
    }

    public function loadDependencies()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
    }

    public function setPublishes()
    {
        $this->publishes([
            __DIR__.'/storage/app' => storage_path('app'),
            __DIR__.'/resources/assets/js' => resource_path('assets/js'),
        ], 'howToVideos-assets');

        $this->publishes([
            __DIR__.'/storage/app' => storage_path('app'),
            __DIR__.'/resources/assets/js' => resource_path('assets/js'),
        ], 'enso-assets');
    }

    public function register()
    {
        //
    }
}
