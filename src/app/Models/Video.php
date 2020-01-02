<?php

namespace LaravelEnso\HowTo\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Files\App\Contracts\Attachable;
use LaravelEnso\Files\App\Traits\HasFile;
use LaravelEnso\HowTo\App\Exceptions\Video as Exception;

class Video extends Model implements Attachable
{
    use HasFile;

    protected $table = 'how_to_videos';

    protected $fillable = ['name', 'description'];

    protected $folder = 'howToVideos';

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

        DB::beginTransaction();

        $video = $this->create($attributes);
        $video->upload($file);

        DB::commit();

        return $video;
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
