<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Video;

class Show extends Controller
{
    public function __invoke(Video $video)
    {
        return $video->inline();
    }
}
