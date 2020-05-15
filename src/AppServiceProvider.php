<?php

namespace LaravelEnso\HowTo;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\HowTo\App\Models\Video;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->mapMorphs()
            ->publish();
    }

    private function load()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        return $this;
    }

    private function mapMorphs()
    {
        Relation::morphMap([
            Video::morphMapKey() => Video::class,
        ]);

        return $this;
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/storage/app' => storage_path('app'),
        ], 'howToVideos-storage');

        return $this;
    }
}
