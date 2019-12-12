<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/howTo')->as('howTo.')
    ->namespace('LaravelEnso\HowTo\app\Http\Controllers')
    ->group(function () {
        require 'app/videos.php';
        require 'app/posters.php';
        require 'app/tags.php';
    });
