<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Http\Requests\ValidateVideoRequest;
use LaravelEnso\HowTo\App\Models\Video;

class Store extends Controller
{
    public function __invoke(ValidateVideoRequest $request, Video $video)
    {
        return $video->store(
            $request->file('video'),
            $request->only(['name', 'description'])
        );
    }
}
