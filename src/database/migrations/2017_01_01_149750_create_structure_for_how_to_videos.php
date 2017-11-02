<?php

use LaravelEnso\StructureManager\app\Classes\StructureMigration;

class CreateStructureForHowToVideos extends StructureMigration
{
    protected $permissionGroup = [
        'name' => 'howToVideos', 'description' => 'How To Videos permissions group',
    ];

    protected $permissions = [
        ['name' => 'howToVideos.index', 'description' => 'How to videos index page', 'type' => 0, 'default' => false],
        ['name' => 'howToVideos.show', 'description' => 'Play video', 'type' => 0, 'default' => false],
        ['name' => 'howToVideos.store', 'description' => 'Upload how to video', 'type' => 1, 'default' => false],
        ['name' => 'howToVideos.update', 'description' => 'Update how to video params', 'type' => 1, 'default' => false],
        ['name' => 'howToVideos.destroy', 'description' => 'Delete how to video', 'type' => 1, 'default' => false],

        ['name' => 'howToTags.index', 'description' => 'How to tags index page', 'type' => 0, 'default' => false],
        ['name' => 'howToTags.store', 'description' => 'Store new how to tag', 'type' => 1, 'default' => false],
        ['name' => 'howToTags.update', 'description' => 'Update how to tag', 'type' => 1, 'default' => false],
        ['name' => 'howToTags.destroy', 'description' => 'Delete how to tag', 'type' => 1, 'default' => false],

        ['name' => 'howToPosters.store', 'description' => 'Store poster for how to video', 'type' => 1, 'default' => false],
        ['name' => 'howToPosters.show', 'description' => 'Show poster for how to video', 'type' => 0, 'default' => false],
        ['name' => 'howToPosters.destroy', 'description' => 'Delete poster for how to video', 'type' => 1, 'default' => false],
    ];

    protected $menu = [
        'name' => 'How To Videos', 'icon' => 'fa fa-fw fa-video-camera', 'link' => 'howToVideos', 'has_children' => false,
    ];
}
