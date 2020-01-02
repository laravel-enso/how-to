<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/howTo')->as('howTo.')
    ->namespace('LaravelEnso\HowTo\App\Http\Controllers')
    ->group(function () {
        require 'app/videos.php';
        require 'app/posters.php';
        require 'app/tags.php';
    });
