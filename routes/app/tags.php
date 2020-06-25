<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Tag')
    ->prefix('tags')
    ->as('tags.')
    ->group(function () {
        Route::get('', 'Index')->name('index');
        Route::post('', 'Store')->name('store');
        Route::delete('{tag}', 'Destroy')->name('destroy');
        Route::patch('{tag}', 'Update')->name('update');
    });
