<?php

namespace LaravelEnso\HowToVideos\app\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\FileManager\app\Traits\HasFile;
use LaravelEnso\ActivityLog\app\Traits\LogActivity;
use LaravelEnso\FileManager\app\Contracts\Attachable;

class Video extends Model implements Attachable
{
    use HasFile, LogActivity;

    protected $table = 'how_to_videos';

    protected $fillable = ['name', 'description'];

    protected $appends = ['tagList'];

    protected $loggableLabel = 'name';

    protected $loggable = ['name', 'description'];

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
        $video = null;

        \DB::transaction(function () use (&$video, $file, $attributes) {
            $video = $this->create($attributes);
            $video->upload($file);
        });

        return $video;
    }

    public function updateWithTags($request)
    {
        \DB::transaction(function () use ($request) {
            $this->update([
                'name' => $request['name'],
                'description' => $request['description'],
            ]);

            $this->tags()->sync($request['tagList']);
        });
    }

    public function getTagListAttribute()
    {
        return $this->tags()
            ->pluck('id');
    }

    public function delete()
    {
        if ($this->poster) {
            $this->poster->delete();
        }

        parent::delete();
    }

    public function folder()
    {
        return config('enso.paths.howToVideos');
    }
}
