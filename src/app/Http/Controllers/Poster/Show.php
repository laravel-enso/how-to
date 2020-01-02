<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Models\Poster;

class Show extends Controller
{
    public function __invoke(Poster $poster)
    {
        return $poster->inline();
    }
}
