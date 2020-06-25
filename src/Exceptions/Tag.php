<?php

namespace LaravelEnso\HowTo\Exceptions;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Tag extends ConflictHttpException
{
    public static function inUse()
    {
        return new self(__('The tag is in use and cannot be deleted'));
    }
}
