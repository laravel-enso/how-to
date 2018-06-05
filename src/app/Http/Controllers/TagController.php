<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidateTagRequest;
use LaravelEnso\HowToVideos\app\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        return Tag::all();
    }

    public function store(ValidateTagRequest $request)
    {
        return Tag::create(['name' => $request->get('name')]);
    }

    public function update(ValidateTagRequest $request, Tag $tag)
    {
        $tag->update($request->only(['name']));
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
    }
}
