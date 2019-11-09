<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Http\Requests\ValidateVideoRequest;
use LaravelEnso\HowTo\app\Models\Video;

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
