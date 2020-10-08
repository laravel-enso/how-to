<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\HowTo\Http\Controllers\Poster\Destroy;
use LaravelEnso\HowTo\Http\Controllers\Poster\Show;
use LaravelEnso\HowTo\Http\Controllers\Poster\Store;

Route::prefix('posters')
    ->as('posters.')
    ->group(function () {
        Route::post('', Store::class)->name('store');
        Route::delete('{poster}', Destroy::class)->name('destroy');
        Route::get('{poster}', Show::class)->name('show');
    });
