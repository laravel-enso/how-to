<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Models\Tag;

class Destroy extends Controller
{
    public function __invoke(Tag $tag)
    {
        $tag->delete();
    }
}
