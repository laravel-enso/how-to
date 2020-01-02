<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Http\Requests\ValidateVideoRequest;
use LaravelEnso\HowTo\App\Models\Video;

class Update extends Controller
{
    public function __invoke(ValidateVideoRequest $request, Video $video)
    {
        tap($video)->update($request->except('tagList'))
            ->syncTags($request->get('tagList'));

        return ['message' => __('The video was updated successfully')];
    }
}
