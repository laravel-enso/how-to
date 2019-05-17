<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Tag;

class Destroy extends Controller
{
    public function __invoke(Tag $tag)
    {
        $tag->delete();
    }
}
