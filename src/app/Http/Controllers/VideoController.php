<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidateVideoRequest;
use LaravelEnso\HowToVideos\app\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        return Video::all();
    }

    public function show(Video $video)
    {
        return $video->video();
    }

    public function store(ValidateVideoRequest $request)
    {
        return Video::store(
            $request->allFiles(),
            $request->only(['name', 'description'])
        );
    }

    public function update(ValidateVideoRequest $request, Video $video)
    {
        $video->updateWithTags(
            $request->only(['name', 'description', 'tagList'])
        );

        return ['message' => __('The video was updated successfully')];
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return ['message' => __('The video file was deleted successfully')];
    }
}
