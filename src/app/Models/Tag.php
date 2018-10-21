<?php

namespace LaravelEnso\HowToVideos\app\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Tag extends Model
{
    protected $table = 'how_to_tags';

    protected $fillable = ['name'];

    public function videos()
    {
        return $this->belongsToMany(
            Video::class, 'how_to_tag_how_to_video', 'how_to_tag_id', 'how_to_video_id'
        );
    }

    public function delete()
    {
        if ($this->videos()->count()) {
            throw new ConflictHttpException(__('The tag is used and cannot be deleted'));
        }

        parent::delete();
    }
}
