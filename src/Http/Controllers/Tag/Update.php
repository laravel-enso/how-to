<?php

namespace LaravelEnso\HowTo\Http\Controllers\Tag;

use Illuminate\Routing\Controller;
use LaravelEnso\HowTo\Http\Requests\ValidateTagRequest;
use LaravelEnso\HowTo\Models\Tag;

class Update extends Controller
{
    public function __invoke(ValidateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
    }
}
