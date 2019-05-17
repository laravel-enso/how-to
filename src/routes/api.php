<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/howTo')->as('howTo.')
    ->namespace('LaravelEnso\HowTo\app\Http\Controllers')
    ->group(function () {
        Route::namespace('Video')
            ->prefix('videos')
            ->as('videos.')
            ->group(function () {
                Route::get('', 'Index')->name('index');
                Route::post('', 'Store')->name('store');
                Route::patch('{video}', 'Update')->name('update');
                Route::delete('{video}', 'Destroy')->name('destroy');
                Route::get('{video}', 'Show')->name('show');
            });

        Route::namespace('Poster')
            ->prefix('posters')
            ->as('posters.')
            ->group(function () {
                Route::post('', 'Store')->name('store');
                Route::delete('{poster}', 'Destroy')->name('destroy');
                Route::get('{poster}', 'Show')->name('show');
            });

        Route::namespace('Tag')
            ->prefix('tags')
            ->as('tags.')
            ->group(function () {
                Route::get('', 'Index')->name('index');
                Route::post('', 'Store')->name('store');
                Route::delete('{tag}', 'Destroy')->name('destroy');
                Route::patch('{tag}', 'Update')->name('update');
            });
    });
