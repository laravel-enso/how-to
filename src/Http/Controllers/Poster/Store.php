<?php

namespace LaravelEnso\HowTo\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\Http\Requests\ValidatePosterRequest;
use LaravelEnso\HowTo\Models\Poster;

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
