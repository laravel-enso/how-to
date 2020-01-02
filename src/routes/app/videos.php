<?php

use Illuminate\Support\Facades\Route;

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
