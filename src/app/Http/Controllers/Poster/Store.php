<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Http\Requests\ValidatePosterRequest;
use LaravelEnso\HowTo\App\Models\Poster;

class Store extends Controller
{
    public function __invoke(ValidatePosterRequest $request, Poster $poster)
    {
        return $poster->store(
            $request->get('videoId'),
            $request->file('poster')
        );
    }
}
