<?php

namespace LaravelEnso\HowTo\App\Exceptions;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Video extends ConflictHttpException
{
    public static function exists()
    {
        return new self(__('This video was already uploaded'));
    }
}
