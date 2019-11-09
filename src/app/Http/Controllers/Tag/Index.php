<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Http\Resources\Tag as Resource;
use LaravelEnso\HowTo\app\Models\Tag;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(Tag::all());
    }
}
