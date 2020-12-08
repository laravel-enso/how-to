<?php

namespace LaravelEnso\HowTo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Files\Contracts\Attachable;
use LaravelEnso\Files\Traits\HasFile;
use LaravelEnso\Helpers\Traits\CascadesMorphMap;
use LaravelEnso\HowTo\Exceptions\Video as Exception;

class Video extends Model implements Attachable
{
    use CascadesMorphMap, HasFile;

    protected $table = 'how_to_videos';

    protected $guarded = ['id'];

    protected string $folder = 'howToVideos';

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

    public function store(UploadedFile $file, array $attributes)
    {
        if (self::whereHas('file', fn ($query) => $query
            ->whereOriginalName($file->getClientOriginalName()))->exists()) {
            throw Exception::exists();
        }

        return DB::transaction(function () use ($file, $attributes) {
            $video = $this->create($attributes);
            $video->file->upload($file);

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
        optional($this->poster)->delete();

        parent::delete();
    }
}
