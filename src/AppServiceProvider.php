<?php

namespace LaravelEnso\HowTo;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\HowTo\Models\Poster;
use LaravelEnso\HowTo\Models\Video;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->mapMorphs();
    }

    private function load()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        return $this;
    }

    private function mapMorphs()
    {
        Video::morphMap();
        Poster::morphMap();
    }
}
