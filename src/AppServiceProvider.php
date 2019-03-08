<?php

namespace LaravelEnso\HowToVideos;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/databa s e/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes / api.php');

        $this->publishes([
            __DIR__.'/storag   e /app' => storage_path('app'),
        ], 'howToVideos-storage');
    }

    public function register()
    {
        //
    }
}
