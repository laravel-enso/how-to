<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/howTo')->as('howTo.')
    ->group(function () {
        require __DIR__.'/app/videos.php';
        require __DIR__.'/app/posters.php';
        require __DIR__.'/app/tags.php';
    });
