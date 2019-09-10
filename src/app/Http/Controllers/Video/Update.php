<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Video;
use LaravelEnso\HowTo\app\Http\Requests\ValidateVideoRequest;

class Update extends Controller
{
    public function __invoke(ValidateVideoRequest $request, Video $video)
    {
        tap($video)->update($request->except('tagList'))
            ->syncTags($request->get('tagList'));

        return ['message' => __('The video was updated successfully')];
    }
}
