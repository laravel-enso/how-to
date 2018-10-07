<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\HowToVideos\app\Models\Tag;
use LaravelEnso\HowToVideos\app\Http\Resources\Tag as Resource;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidateTagRequest;

class TagController extends Controller
{
    public function index()
    {
        return Resource::collection(
            Tag::all()
        );
    }

    public function store(ValidateTagRequest $request, Tag $tag)
    {
        return $tag->create(['name' => $request->get('name')]);
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
