<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidatePosterRequest;
use LaravelEnso\HowToVideos\app\Models\Video;

class PosterController extends Controller
{
    public function show($id)
    {
        return Video::find($id)
            ->poster();
    }

    public function store(ValidatePosterRequest $request)
    {
        return Video::find($request->get('videoId'))
            ->addPoster($request->allFiles());
    }

    public function destroy($id)
    {
        Video::find($id)
            ->removePoster();

        return ['message' => __('The poster was deleted successfully')];
    }
}
