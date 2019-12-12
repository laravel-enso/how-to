<?php

namespace LaravelEnso\HowTo\app\Exceptions;

use LaravelEnso\Helpers\app\Exceptions\EnsoException;

class Video extends EnsoException
{
    public static function alreadyUploaded()
    {
        throw new static(__('This video was already uploaded'));
    }
}
