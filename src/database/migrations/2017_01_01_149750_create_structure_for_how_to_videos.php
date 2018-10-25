<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForHowToVideos extends StructureMigration
{
    protected $permissions = [
        ['name' => 'howTo.videos.index', 'description' => 'How to videos index page', 'type' => 0, 'is_default' => true],
        ['name' => 'howTo.videos.show', 'description' => 'Play video', 'type' => 0, 'is_default' => true],
        ['name' => 'howTo.videos.store', 'description' => 'Upload how to video', 'type' => 1, 'is_default' => false],
        ['name' => 'howTo.videos.update', 'description' => 'Update how to video', 'type' => 1, 'is_default' => false],
        ['name' => 'howTo.videos.destroy', 'description' => 'Delete how to video', 'type' => 1, 'is_default' => false],

        ['name' => 'howTo.tags.index', 'description' => 'Tags index page', 'type' => 0, 'is_default' => true],
        ['name' => 'howTo.tags.store', 'description' => 'Store new tag', 'type' => 1, 'is_default' => false],
        ['name' => 'howTo.tags.update', 'description' => 'Update tag', 'type' => 1, 'is_default' => false],
        ['name' => 'howTo.tags.destroy', 'description' => 'Delete tag', 'type' => 1, 'is_default' => false],

        ['name' => 'howTo.posters.store', 'description' => 'Store new poster', 'type' => 1, 'is_default' => false],
        ['name' => 'howTo.posters.show', 'description' => 'Show poster', 'type' => 0, 'is_default' => true],
        ['name' => 'howTo.posters.destroy', 'description' => 'Delete poster', 'type' => 1, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'How To Videos', 'icon' => 'video', 'route' => 'howTo.videos.index', 'has_children' => false, 'order_index' => 1000,
    ];
}
