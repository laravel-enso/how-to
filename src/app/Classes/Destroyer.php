<?php

namespace LaravelEnso\HowToVideos\app\Classes;

use Illuminate\Database\Eloquent\Model;

class Destroyer extends Handler
{
    private $model;

    public function __construct(Model $model)
    {
        parent::__construct();

        $this->model = $model;
    }

    public function run()
    {
        $this->fileManager
            ->delete($this->model->{$this->savedName()});
    }
}
