<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\HowToVideos\app\Models\Video;
use LaravelEnso\HowToVideos\app\Http\Resources\Video as Resource;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidateVideoRequest;

class VideoController extends Controller
{
    public function index()
    {
        return Resource::collection(
            Video::with(['poster', 'tags'])
                ->get()
        );
    }

    public function show(Video $video)
    {
        return $video->inline();
    }

    public function store(ValidateVideoRequest $request, Video $video)
    {
        return $video->store(
            $request->file('video'),
            $request->only(['name', 'description'])
        );
    }

    public function update(ValidateVideoRequest $request, Video $video)
    {
        tap($video)->update($request->except('tagList'))
            ->syncTags($request->get('tagList'));

        return [
            'message' => __('The video was updated successfully'),
        ];
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return [
            'message' => __('The video file was deleted successfully'),
        ];
    }
}
