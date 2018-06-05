<?php

namespace LaravelEnso\HowToVideos\app\Classes;

use LaravelEnso\HowToVideos\app\Models\Video;
use LaravelEnso\ImageTransformer\app\Classes\ImageTransformer;

class Storer extends Handler
{
    private const ImageHeight = 300;
    private const ImageWidth = 300;

    private $file;
    private $attributes;

    public function __construct(array $file, array $attributes)
    {
        parent::__construct();

        $this->file = $file;
        $this->attributes = $attributes;
        $this->fileManager->tempPath(config('enso.config.paths.temp'));
    }

    public function run()
    {
        $file = null;

        try {
            \DB::transaction(function () use (&$file) {
                if ($this->isPoster()) {
                    $this->processImage();
                }

                $this->fileManager->startUpload($this->file);
                $file = $this->persist();
                $this->fileManager->commitUpload();
            });
        } catch (\Exception $exception) {
            $this->fileManager->deleteTempFiles();
            throw $exception;
        }

        return $file;
    }

    private function persist()
    {
        $file = $this->fileManager
            ->uploadedFiles()
            ->first();

        return $this->isVideo()
            ? $this->store($file)
            : $this->update($file);
    }

    private function store($file)
    {
        return Video::create(
            array_merge([
                $this->originalName() => $file['original_name'],
                $this->savedName() => $file['saved_name'],
            ], $this->attributes)
        );
    }

    private function update($file)
    {
        Video::find($this->attributes['id'])
            ->update([
                $this->originalName() => $file['original_name'],
                $this->savedName() => $file['saved_name'],
            ]);

        return $file;
    }

    private function processImage()
    {
        (new ImageTransformer(collect($this->file)->first()))
            ->width(self::ImageWidth)
            ->height(self::ImageHeight)
            ->optimize();
    }
}
