<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Poster;
use LaravelEnso\HowTo\app\Http\Requests\ValidatePosterRequest;

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
