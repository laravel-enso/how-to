<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\HowToVideos\app\Http\Services\HowToPosterService;
use LaravelEnso\HowToVideos\app\Models\HowToVideo;

class HowToPosterController extends Controller
{
    private $service;

    public function __construct(HowToPosterService $service)
    {
        $this->service = $service;
    }

    public function show(HowToVideo $howToVideo)
    {
        return $this->service->show($howToVideo);
    }

    public function store(Request $request, HowToVideo $howToVideo)
    {
        return $this->service->store($request, $howToVideo);
    }

    public function destroy(HowToVideo $howToVideo)
    {
        return $this->service->destroy($howToVideo);
    }
}
