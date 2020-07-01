<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForHowTo extends Migration
{
    protected array $permissions = [
        ['name' => 'howTo.videos.index', 'description' => 'How to videos index page', 'is_default' => true],
        ['name' => 'howTo.videos.show', 'description' => 'Play video', 'is_default' => true],
        ['name' => 'howTo.videos.store', 'description' => 'Upload how to video', 'is_default' => false],
        ['name' => 'howTo.videos.update', 'description' => 'Update how to video', 'is_default' => false],
        ['name' => 'howTo.videos.destroy', 'description' => 'Delete how to video', 'is_default' => false],

        ['name' => 'howTo.tags.index', 'description' => 'Tags index page', 'is_default' => true],
        ['name' => 'howTo.tags.store', 'description' => 'Store new tag', 'is_default' => false],
        ['name' => 'howTo.tags.update', 'description' => 'Update tag', 'is_default' => false],
        ['name' => 'howTo.tags.destroy', 'description' => 'Delete tag', 'is_default' => false],

        ['name' => 'howTo.posters.store', 'description' => 'Store new poster', 'is_default' => false],
        ['name' => 'howTo.posters.show', 'description' => 'Show poster', 'is_default' => true],
        ['name' => 'howTo.posters.destroy', 'description' => 'Delete poster', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'How To Videos', 'icon' => 'video', 'route' => 'howTo.videos.index', 'has_children' => false, 'order_index' => 1000,
    ];
}
