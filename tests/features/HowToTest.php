<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use LaravelEnso\Helpers\Traits\EnsuresTestingFolder;
use LaravelEnso\HowTo\Models\Poster;
use LaravelEnso\HowTo\Models\Tag;
use LaravelEnso\HowTo\Models\Video;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HowToTest extends TestCase
{
    use EnsuresTestingFolder;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureTestingFolder();

        $this->seed()
            ->actingAs(User::first());
    }

    protected function tearDown(): void
    {
        Storage::deleteDirectory(config('enso.files.testingFolder'));

        parent::tearDown();
    }

    #[Test]
    public function can_store_list_stream_and_delete_videos(): void
    {
        $response = $this->post(route('howTo.videos.store', [], false), [
            'video'       => UploadedFile::fake()->create('guide.mp4', 256, 'video/mp4'),
            'name'        => 'Install Guide',
            'description' => 'Step by step',
        ])->assertStatus(201);

        $videoId = $response->json('id');
        $video = Video::query()->findOrFail($videoId);

        $this->get(route('howTo.videos.index', [], false))
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $videoId, 'name' => 'Install Guide']);

        $this->get(route('howTo.videos.show', $videoId, false))
            ->assertStatus(200);

        $this->delete(route('howTo.videos.destroy', $videoId, false))
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'The video file was deleted successfully']);

        $this->assertDatabaseMissing('how_to_videos', ['id' => $videoId]);
        $this->assertDatabaseMissing('files', ['id' => $video->file_id]);
    }

    #[Test]
    public function can_update_video_and_sync_tags(): void
    {
        $video = $this->createVideo('Original');
        $firstTag = Tag::create(['name' => 'first']);
        $secondTag = Tag::create(['name' => 'second']);

        $this->patch(route('howTo.videos.update', $video->id, false), [
            'name'        => 'Updated',
            'description' => 'Updated description',
            'tagList'     => [$firstTag->id, $secondTag->id],
        ])->assertStatus(200)
            ->assertJsonFragment(['message' => 'The video was updated successfully']);

        $this->assertSame('Updated', $video->fresh()->name);
        $this->assertEqualsCanonicalizing(
            [$firstTag->id, $secondTag->id],
            $video->fresh()->tagList()->all()
        );
    }

    #[Test]
    public function can_store_update_list_and_delete_tags(): void
    {
        $storeResponse = $this->post(route('howTo.tags.store', [], false), [
            'name' => 'installation',
        ])->assertStatus(201);

        $tagId = $storeResponse->json('id');

        $this->get(route('howTo.tags.index', [], false))
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $tagId, 'name' => 'installation']);

        $this->patch(route('howTo.tags.update', $tagId, false), [
            'name' => 'updated-installation',
        ])->assertStatus(200);

        $this->delete(route('howTo.tags.destroy', $tagId, false))
            ->assertStatus(200);

        $this->assertDatabaseMissing('how_to_tags', ['id' => $tagId]);
    }

    #[Test]
    public function can_store_show_and_delete_posters(): void
    {
        $video = $this->createVideo('Poster target');

        $response = $this->post(route('howTo.posters.store', [], false), [
            'videoId' => $video->id,
            'poster'  => UploadedFile::fake()->image('poster.png'),
        ])->assertStatus(201);

        $posterId = $response->json('id');
        $poster = Poster::query()->findOrFail($posterId);

        $this->get(route('howTo.posters.show', $posterId, false))
            ->assertStatus(200);

        $this->delete(route('howTo.posters.destroy', $posterId, false))
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'The poster was deleted successfully']);

        $this->assertDatabaseMissing('how_to_posters', ['id' => $posterId]);
        $this->assertDatabaseMissing('files', ['id' => $poster->file_id]);
    }

    private function createVideo(string $name): Video
    {
        $response = $this->post(route('howTo.videos.store', [], false), [
            'video'       => UploadedFile::fake()->create('guide.mp4', 256, 'video/mp4'),
            'name'        => $name,
            'description' => 'Stored from helper',
        ])->assertStatus(201);

        return Video::query()->findOrFail($response->json('id'));
    }
}
