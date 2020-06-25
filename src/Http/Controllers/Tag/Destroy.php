<?php

namespace LaravelEnso\HowTo\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\Models\Tag;

class Destroy extends Controller
{
    public function __invoke(Tag $tag)
    {
        $tag->delete();
    }
}
