<?php

namespace LaravelEnso\HowTo\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Files\app\Contracts\Attachable;
use LaravelEnso\Files\app\Traits\HasFile;

class Poster extends Model implements Attachable
{
    use HasFile;

    private const Width = 800;
    private const Height = 800;

    protected $optimizeImages = true;

    protected $resizeImages = [
        'width' => self::Width,
        'height' => self::Height,
    ];

    protected $table = 'how_to_posters';

    protected $fillable = ['video_id'];

    protected $folder = 'howToVideos';

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function store(int $videoId, UploadedFile $file)
    {
        $poster = null;

        DB::transaction(function () use (&$poster, $videoId, $file) {
            $poster = self::create(['video_id' => $videoId]);
            $poster->upload($file);
        });

        return $poster;
    }
}
