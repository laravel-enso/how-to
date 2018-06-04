<?php

namespace LaravelEnso\HowToVideos\app\Models;

use Illuminate\Database\Eloquent\Model;

class HowToTag extends Model
{
    protected $fillable = ['name'];

    protected $appends = ['selected'];

    public function videos()
    {
        return $this->belongsToMany(HowToVideo::class);
    }

    public function getSelectedAttribute()
    {
        return false;
    }
}
