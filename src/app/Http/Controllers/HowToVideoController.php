<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidateVideoRequest;
use LaravelEnso\HowToVideos\app\Http\Services\HowToVideoService;
use LaravelEnso\HowToVideos\app\Models\HowToVideo;

class HowToVideoController extends Controller
{
    private $service;

    public function __construct(HowToVideoService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show(HowToVideo $howToVideo)
    {
        return $this->service->show($howToVideo);
    }

    public function store(ValidateVideoRequest $request, HowToVideo $video)
    {
        return $this->service->store($request, $video);
    }

    public function update(ValidateVideoRequest $request, HowToVideo $howToVideo)
    {
        return $this->service->update($request, $howToVideo);
    }

    public function destroy(HowToVideo $howToVideo)
    {
        return $this->service->destroy($howToVideo);
    }
}
