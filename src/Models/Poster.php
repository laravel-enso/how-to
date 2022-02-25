<?php

namespace LaravelEnso\HowTo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Files\Contracts\Attachable;
use LaravelEnso\Files\Contracts\OptimizesImages;
use LaravelEnso\Files\Contracts\ResizesImages;
use LaravelEnso\Files\Models\File;

class Poster extends Model implements Attachable, OptimizesImages, ResizesImages
{
    protected $table = 'how_to_posters';

    protected $guarded = [];

    protected string $folder = 'howToVideos';

    public function file(): Relation
    {
        return $this->belongsTo(File::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function imageWidth(): ?int
    {
        return 800;
    }

    public function imageHeight(): ?int
    {
        return 800;
    }

    public function store(int $videoId, UploadedFile $uploadedFile): self
    {
        return DB::transaction(function () use ($videoId, $uploadedFile) {
            $poster = self::create(['video_id' => $videoId]);
            $file = File::upload($poster, $uploadedFile);
            $poster->file()->associate($file)->save();

            return $poster;
        });
    }

    public function delete()
    {
        parent::delete();
        $this->file->delete();
    }
}
