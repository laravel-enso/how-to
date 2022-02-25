<?php

namespace LaravelEnso\HowTo\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\Http\Requests\ValidatePoster;
use LaravelEnso\HowTo\Models\Poster;

class Store extends Controller
{
    public function __invoke(ValidatePoster $request, Poster $poster)
    {
        return $poster->store($request->get('videoId'), $request->file('poster'));
    }
}
