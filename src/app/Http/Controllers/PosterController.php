<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidatePosterRequest;
use LaravelEnso\HowToVideos\app\Models\HowToVideo;

class PosterController extends Controller
{
    public function show($id)
    {
        return HowToVideo::find($id)
            ->poster();
    }

    public function store(ValidatePosterRequest $request)
    {
        return HowToVideo::find($request->get('videoId'))
            ->addPoster($request->allFiles());
    }

    public function destroy($id)
    {
        HowToVideo::find($id)
            ->removePoster();

        return ['message' => __('The poster was deleted successfully')];
    }
}
