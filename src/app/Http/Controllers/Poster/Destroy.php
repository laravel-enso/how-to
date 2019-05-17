<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Poster;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Poster;

class Destroy extends Controller
{
    public function __invoke(Poster $poster)
    {
        $poster->delete();

        return [
            'message' => __('The poster was deleted successfully'),
        ];
    }
}
