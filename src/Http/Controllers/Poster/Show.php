<?php

namespace LaravelEnso\HowTo\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\Models\Poster;

class Show extends Controller
{
    public function __invoke(Poster $poster)
    {
        return $poster->file->inline();
    }
}
