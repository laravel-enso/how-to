<?php

namespace LaravelEnso\HowToVideos\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\HowToVideos\app\Models\HowToTag;

class HowToVideo extends Model
{
    protected $fillable = ['description', 'original_name', 'saved_name', 'poster_original_name', 'poster_saved_name'];

    protected $appends = ['tagList'];

    public function tags()
    {
        return $this->belongsToMany(HowToTag::class);
    }

    public function getTagListAttribute()
    {
    	return $this->tags()->pluck('id');
    }
}
