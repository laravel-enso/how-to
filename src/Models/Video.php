<?php

namespace LaravelEnso\HowTo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Files\Contracts\Attachable;
use LaravelEnso\Files\Models\File;

class Video extends Model implements Attachable
{
    protected $table = 'how_to_videos';

    protected $guarded = [];

    public function file(): Relation
    {
        return $this->belongsTo(File::class);
    }

    public function poster()
    {
        return $this->hasOne(Poster::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'how_to_tag_how_to_video',
            'how_to_video_id',
            'how_to_tag_id'
        );
    }

    public function store(UploadedFile $uploadedFile, array $attributes): self
    {
        return DB::transaction(function () use ($uploadedFile, $attributes) {
            $video = $this->create($attributes);
            $file = File::upload($video, $uploadedFile);
            $video->file()->associate($file)->save();

            return $video;
        });
    }

    public function syncTags($tagList)
    {
        $this->tags()->sync($tagList);
    }

    public function tagList()
    {
        return $this->tags()->pluck('id');
    }

    public function delete()
    {
        $this->poster?->delete();

        parent::delete();
    }
}
