<?php

namespace LaravelEnso\HowToVideos\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\FileManager\Classes\FileManager;
use LaravelEnso\HowToVideos\app\Models\HowToVideo;
use LaravelEnso\ImageTransformer\app\Classes\ImageTransformer;

class HowToPosterService
{
    private $fileManager;

    public function show(HowToVideo $video)
    {
        $this->setFileManager();

        return $this->fileManager->getInline($video->poster_saved_name);
    }

    public function store(Request $request, HowToVideo $video)
    {
        $this->setFileManager();

        try {
            \DB::transaction(function () use ($request, &$video) {
                $files = $request->allFiles();
                $this->optimize($files);
                $this->fileManager->startUpload($files);
                $poster = $this->fileManager->getUploadedFiles()->first();
                $video->fill(
                    [
                        'poster_original_name' => $poster['original_name'],
                        'poster_saved_name'    => $poster['saved_name'],
                    ] + $request->only(['description'])
                );
                $video->save();
                $this->fileManager->commitUpload();
            });
        } catch (\Exception $e) {
            $this->fileManager->deleteTempFiles();

            throw $e;
        }

        return [
            'video'   => $video->load(['tags']),
            'message' => config('labels.successfulOperation'),
        ];
    }

    public function destroy(HowToVideo $video)
    {
        $this->setFileManager();

        \DB::transaction(function () use ($video) {
            $poster = $video->poster_saved_name;
            $video->poster_original_name = null;
            $video->poster_saved_name = null;
            $video->save();
            $this->fileManager->delete($poster);
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

    private function optimize($files)
    {
        (new ImageTransformer(collect($files)->first()))
            ->width(640)
            ->optimize();
    }
}
