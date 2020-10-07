<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\HowTo\Http\Controllers\Tag\Destroy;
use LaravelEnso\HowTo\Http\Controllers\Tag\Index;
use LaravelEnso\HowTo\Http\Controllers\Tag\Store;
use LaravelEnso\HowTo\Http\Controllers\Tag\Update;

Route::prefix('tags')
    ->as('tags.')
    ->group(function () {
        Route::get('', Index::class)->name('index');
        Route::post('', Store::class)->name('store');
        Route::delete('{tag}', Destroy::class)->name('destroy');
        Route::patch('{tag}', Update::class)->name('update');
    });
