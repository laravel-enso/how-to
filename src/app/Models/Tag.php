<?php

namespace LaravelEnso\HowTo\App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\HowTo\App\Exceptions\Tag as Exception;

class Tag extends Model
{
    protected $table = 'how_to_tags';

    protected $fillable = ['name'];

    public function videos()
    {
        return $this->belongsToMany(
            Video::class,
            'how_to_tag_how_to_video',
            'how_to_tag_id',
            'how_to_video_id'
        );
    }

    public function delete()
    {
        if ($this->videos()->exists()) {
            throw Exception::inUse();
        }

        parent::delete();
    }
}
