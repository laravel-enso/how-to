<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Poster;

class Show extends Controller
{
    public function __invoke(Poster $poster)
    {
        return $poster->inline();
    }
}
