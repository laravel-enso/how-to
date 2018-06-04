<?php

namespace LaravelEnso\HowToVideos\app\Classes;

use Illuminate\Database\Eloquent\Model;

class Presenter extends Handler
{
    private $model;

    public function __construct(Model $model)
    {
        parent::__construct();

        $this->model = $model;
    }

    public function inline()
    {
        return $this->fileManager
            ->inline($this->model->{$this->savedName()});
    }
}
