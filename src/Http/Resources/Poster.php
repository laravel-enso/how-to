<?php

namespace LaravelEnso\HowTo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Poster extends JsonResource
{
    public function toArray($request)
    {
        return ['id' => $this->id];
    }
}
