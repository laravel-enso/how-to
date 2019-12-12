<?php

Route::namespace('Poster')
    ->prefix('posters')
    ->as('posters.')
    ->group(function () {
        Route::post('', 'Store')->name('store');
        Route::delete('{poster}', 'Destroy')->name('destroy');
        Route::get('{poster}', 'Show')->name('show');
    });
