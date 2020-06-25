<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/howTo')->as('howTo.')
    ->namespace('LaravelEnso\HowTo\Http\Controllers')
    ->group(function () {
        require 'app/videos.php';
        require 'app/posters.php';
        require 'app/tags.php';
    });
