<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\HowToVideos\app\Models\HowToTag;
use LaravelEnso\HowToVideos\app\Http\Requests\ValidateTagRequest;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class TagController extends Controller
{
    public function index()
    {
        return HowToTag::all();
    }

    public function store(ValidateTagRequest $request)
    {
        return HowToTag::create(['name' => $request->get('name')]);
    }

    public function update(ValidateTagRequest $request, $id)
    {
        HowToTag::find($id)
            ->update($request->only(['name']));
    }

    public function destroy($id)
    {
        $tag = HowToTag::find($id);

        if ($tag->videos()->count()) {
            throw new ConflictHttpException(__('The tag is used and cannot be deleted'));
        }

        $tag->delete();
    }
}
