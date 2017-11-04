<?php

namespace LaravelEnso\HowToVideos\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\HowToVideos\app\Models\HowToTag;

class HowToTagController extends Controller
{
    public function index()
    {
        return HowToTag::get(['name', 'id']);
    }

    public function store(Request $request)
    {
        $tag = HowToTag::create(['name' => $request->get('name')]);

        return [
            'message' => config('labels.successfulOperation'),
            'tag'     => $tag,
        ];
    }

    public function update(Request $request, HowToTag $howToTag)
    {
        $howToTag->update($request->only(['name']));

        return ['message' => config('labels.successfulOperation')];
    }

    public function destroy(HowToTag $howToTag)
    {
        if ($howToTag->videos()->count()) {
            throw new \EnsoException(__('The tag is used and cannot be deleted'));
        }

        $howToTag->delete();

        return ['message' => config('labels.successfulOperation')];
    }
}
