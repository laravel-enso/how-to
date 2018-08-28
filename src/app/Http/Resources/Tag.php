<?php

namespace LaravelEnso\HowToVideos\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tag extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'selected' => false,
        ];
    }
}
