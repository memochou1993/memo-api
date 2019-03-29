<?php

namespace Tests\Feature;

use App\Tag;
use App\Type;
use App\User;
use App\Record;
use App\RecordTag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagModelTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $type;

    protected $record;

    protected $tag;

    protected $record_tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->type = factory(Type::class)->create();

        $this->record = factory(Record::class)->create([
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
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
        $tag = $this->tag;

        $this->assertEquals(1, $tag->user()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToManyRecords()
    {
        $tag = $this->tag;

        $this->assertEquals(1, $tag->records()->count());
    }
}
