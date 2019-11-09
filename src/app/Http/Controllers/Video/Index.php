<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Http\Resources\Video as Resource;
use LaravelEnso\HowTo\app\Models\Video;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(
            Video::with(['poster', 'tags'])->get()
        );
    }
}
