<?php

namespace LaravelEnso\HowTo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePoster extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'poster' => 'image',
            'videoId' => 'required|exists:how_to_videos,id',
        ];
    }
}
