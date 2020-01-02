<?php

namespace LaravelEnso\HowTo\App\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\App\Models\Poster;

class Destroy extends Controller
{
    public function __invoke(Poster $poster)
    {
        $poster->delete();

        return ['message' => __('The poster was deleted successfully')];
    }
}
