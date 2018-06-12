<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/howTo')->as('howTo.')
    ->namespace('LaravelEnso\HowToVideos\app\Http\Controllers')
    ->group(function () {
        Route::resource('videos', 'VideoController', ['except' => ['create', 'edit']]);
        Route::resource('tags', 'TagController', ['except' => ['show', 'create', 'edit']]);
        Route::resource('posters', 'PosterController', ['only' => ['store', 'show', 'destroy']]);
    });
