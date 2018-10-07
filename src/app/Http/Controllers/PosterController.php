<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\HowToVideos\app\Models\Poster;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidatePosterRequest;

class PosterController extends Controller
{
    public function show(Poster $poster)
    {
        return $poster->inline();
    }

    public function store(ValidatePosterRequest $request, Poster $poster)
    {
        return $poster->store(
            $request->get('videoId'),
            $request->file('poster')
        );
    }

    public function destroy(Poster $poster)
    {
        $poster->delete();

        return [
            'message' => __('The poster was deleted successfully'),
        ];
    }
}
