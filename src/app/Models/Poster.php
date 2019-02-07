<?php

namespace LaravelEnso\HowToVideos\app\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\FileManager\app\Traits\HasFile;
use LaravelEnso\FileManager\app\Contracts\Attachable;

class Poster extends Model implements Attachable
{
    use HasFile;

    protected $optimizeImages = true;

    protected $resizesImages = [800, 800];

    protected $table = 'how_to_posters';

    protected $fillable = ['video_id'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function store(int $videoId, UploadedFile $file)
    {
        $poster = null;

        \DB::transaction(function () use (&$poster, $videoId, $file) {
            $poster = Poster::create(['video_id' => $videoId]);
            $poster->upload($file);
        });

        return $poster;
    }

    public function folder()
    {
        return config('enso.config.paths.howToVideos');
    }
}
