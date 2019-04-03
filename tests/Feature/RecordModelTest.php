<?php

namespace Tests\Feature;

use App\Tag;
use App\User;
use App\Record;
use App\RecordTag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordModelTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $record;

    protected $tag;

    protected $record_tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->record = factory(Record::class)->create([
            'user_id' => $this->user->id,
        ]);

        $this->tag = factory(Tag::class)->create([
            'user_id' => $this->user->id,
        ]);

        $this->record_tag = factory(RecordTag::class)->create([
            'record_id' => $this->record->id,
            'tag_id' => $this->tag->id,
        ]);
    }

    /**
     * @return void
     */
    public function testBelongsToUser()
    {
        $record = $this->record;

        $this->assertEquals(1, $record->user()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToManyTags()
    {
        $record = $this->record;

        $this->assertEquals(1, $record->tags()->count());
    }
}
