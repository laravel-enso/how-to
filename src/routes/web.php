<?php

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\HowToVideos\app\Http\Controllers')
    ->group(function () {
        Route::resource('howToVideos', 'HowToVideoController', ['except' => ['create', 'edit']]);
        Route::resource('howToTags', 'HowToTagController', ['except' => ['show', 'create', 'edit']]);
        Route::post('howToPosters/{howToVideo}', 'HowToPosterController@store')
            ->name('howToPosters.store');

        Route::get('howToPosters/{howToVideo}', 'HowToPosterController@show')
            ->name('howToPosters.show');

        Route::delete('howToPosters/{howToVideo}', 'HowToPosterController@destroy')
            ->name('howToPosters.destroy');
    });
