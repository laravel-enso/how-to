<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Http\Resources\Tag as Resource;
use LaravelEnso\HowTo\App\Models\Tag;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(Tag::all());
    }
}
