<?php

namespace LaravelEnso\HowToVideos\app\Classes;

use LaravelEnso\FileManager\app\Classes\FileManager;

abstract class Handler
{
    protected $fileManager;
    private $prefix;

    public function __construct()
    {
        $this->fileManager = new FileManager(
            config('enso.config.paths.howToVideos')
        );
    }

    public function video()
    {
        $this->prefix = 'video';

        return $this;
    }

    public function poster()
    {
        $this->prefix = 'poster';

        return $this;
    }

    public function isVideo()
    {
        return $this->prefix === 'video';
    }

    public function isPoster()
    {
        return $this->prefix === 'poster';
    }

    protected function originalName()
    {
        return $this->prefix.'_original_name';
    }

    protected function savedName()
    {
        return $this->prefix.'_saved_name';
    }
}
