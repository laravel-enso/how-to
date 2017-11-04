<?php

namespace LaravelEnso\HowToVideos\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\FileManager\Classes\FileManager;
use LaravelEnso\HowToVideos\app\Models\HowToVideo;

class HowToVideoService
{
    private $fileManager;

    public function index()
    {
        $videos = HowToVideo::with(['tags'])->get();

        return view('laravel-enso/howToVideos::index', compact('videos'));
    }

    public function show(HowToVideo $video)
    {
        $this->setFileManager();

        return $this->fileManager->getInline($video->saved_name);
    }

    public function store(Request $request, HowToVideo $video)
    {
        $this->setFileManager();

        try {
            \DB::transaction(function () use ($request, &$video) {
                $this->fileManager->startUpload($request->allFiles());
                $video->fill($this->fileManager->getUploadedFiles()->first() + $request->only(['description']));
                $video->save();
                $this->fileManager->commitUpload();
            });
        } catch (\Exception $e) {
            $this->fileManager->deleteTempFiles();

            throw $e;
        }

        return [
            'video'   => $video->fresh(),
            'message' => config('labels.successfulOperation'),
        ];
    }

    public function update(Request $request, HowToVideo $video)
    {
        \DB::transaction(function () use ($video, $request) {
            $video->description = $request->get('description');
            $video->tags()->sync($request->get('tagList'));
            $video->save();
        });

        return ['message' => config('labels.successfulOperation')];
    }

    public function destroy(HowToVideo $video)
    {
        $this->setFileManager();

        \DB::transaction(function () use ($video) {
            $video->delete();
            if (!is_null($video->poster_saved_name)) {
                $this->fileManager->delete($video->poster_saved_name);
            }
            $this->fileManager->delete($video->saved_name);
        });

        return ['message' => config('labels.successfulOperation')];
    }

    private function setFileManager()
    {
        $this->fileManager = new FileManager(
            config('laravel-enso.paths.howToVideos'),
            config('laravel-enso.paths.temp')
        );
    }
}
