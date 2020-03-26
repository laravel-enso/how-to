<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Video;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Http\Resources\Video as Resource;
use LaravelEnso\HowTo\App\Models\Video;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(
            Video::with(['poster', 'tags'])->get()
        );
    }
}
