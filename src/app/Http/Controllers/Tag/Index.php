<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Tag;
use LaravelEnso\HowTo\app\Http\Resources\Tag as Resource;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(Tag::all());
    }
}
