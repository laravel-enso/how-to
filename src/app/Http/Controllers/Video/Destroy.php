<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Video;

class Destroy extends Controller
{
    public function __invoke(Video $video)
    {
        $video->delete();

        return [
            'message' => __('The video file was deleted successfully'),
        ];
    }
}
