<?php

namespace LaravelEnso\HowToVideos\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateVideoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/webm',
            'name' => 'required|max:255',
            'description' => 'max:255',
        ];
    }
}
