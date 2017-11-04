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
            'file_0'      => 'mimetypes:video/avi,video/mpeg,video/quicktime',
            'description' => 'required|max:255',
        ];
    }
}
