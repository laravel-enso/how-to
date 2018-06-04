<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidateVideoRequest;
use LaravelEnso\HowToVideos\app\Models\HowToVideo;

class VideoController extends Controller
{
    public function index()
    {
        return HowToVideo::all();
    }

    public function show($id)
    {
        return HowToVideo::find($id)
            ->video();
    }

    public function store(ValidateVideoRequest $request)
    {
        return HowToVideo::store(
            $request->allFiles(),
            $request->only(['name', 'description'])
        );
    }

    public function update(ValidateVideoRequest $request, $id)
    {
        HowToVideo::find($id)
            ->updateWithTags(
                $request->only(['name', 'description', 'tagList'])
            );

        return ['message' => __('The video was updated successfully')];
    }

    public function destroy($id)
    {
        HowToVideo::find($id)
            ->delete();

        return ['message' => __('The video file was deleted successfully')];
    }
}
