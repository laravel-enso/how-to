<?php

namespace LaravelEnso\HowTo\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\Http\Resources\Tag as Resource;
use LaravelEnso\HowTo\Models\Tag;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(Tag::all());
    }
}
