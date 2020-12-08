<?php

namespace LaravelEnso\HowTo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Files\Contracts\Attachable;
use LaravelEnso\Files\Traits\HasFile;
use LaravelEnso\Helpers\Traits\CascadesMorphMap;

class Poster extends Model implements Attachable
{
    use CascadesMorphMap, HasFile;

    private const Width = 800;
    private const Height = 800;

    protected bool $optimizeImages = true;

    protected array $resizeImages = [
        'width' => self::Width,
        'height' => self::Height,
    ];

    protected $table = 'how_to_posters';

    protected $guarded = ['id'];

    protected string $folder = 'howToVideos';

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function store(int $videoId, UploadedFile $file)
    {
        return DB::transaction(function () use ($videoId, $file) {
            $poster = self::create(['video_id' => $videoId]);
            $poster->file->upload($file);

            return $poster;
        });
    }
}
