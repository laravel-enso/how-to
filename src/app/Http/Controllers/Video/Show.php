<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Models\Video;

class Show extends Controller
{
    public function __invoke(Video $video)
    {
        return $video->inline();
    }
}
