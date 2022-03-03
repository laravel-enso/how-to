<?php

namespace LaravelEnso\HowTo\Upgrades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Upgrade\Contracts\BeforeMigration;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class UpdateMigrationOrder implements MigratesData, BeforeMigration
{
    private const Mapping = [
        '2017_01_01_100000_create_how_to_videos_table' => '2018_01_01_100000_create_how_to_videos_table',
        '2017_01_01_101000_create_how_to_tags_table' => '2018_01_01_101000_create_how_to_tags_table',
        '2017_01_01_102000_create_how_to_tag_how_to_video_pivot_table' => '2018_01_01_102000_create_how_to_tag_how_to_video_pivot_table',
        '2017_01_01_103000_create_how_to_posters_table' => '2018_01_01_103000_create_how_to_posters_table',
        '2017_01_01_104000_create_structure_for_how_to' => '2018_01_01_104000_create_structure_for_how_to',
    ];

    private Collection $mapping;

    public function __construct()
    {
        $this->mapping = Collection::wrap(self::Mapping);
    }

    public function isMigrated(): bool
    {
        return DB::table('migrations')
            ->whereIn('migration', $this->mapping->keys())
            ->doesntExist();
    }

    public function migrateData(): void
    {
        $this->mapping->each(fn ($to, $from) => $this->update($from, $to));
    }

    private function update($from, $to): void
    {
        DB::table('migrations')
            ->whereMigration($from)
            ->update(['migration' => $to]);
    }
}
