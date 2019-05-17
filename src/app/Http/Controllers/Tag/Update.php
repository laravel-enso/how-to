<?php

namespace LaravelEnso\HowTo\app\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\app\Models\Tag;
use LaravelEnso\HowTo\app\Http\Requests\ValidateTagRequest;

class Update extends Controller
{
    public function __invoke(ValidateTagRequest $request, Tag $tag)
    {
        $tag->update($request->only(['name']));
    }
}
