<?php

namespace LaravelEnso\HowTo\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\Http\Requests\ValidateVideo;
use LaravelEnso\HowTo\Models\Video;

class Store extends Controller
{
    public function __invoke(ValidateVideo $request, Video $video)
    {
        return $video->store(
            $request->file('video'),
            $request->validatedExcept('video')
        );
    }
}
