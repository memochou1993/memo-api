<?php

namespace Tests\Feature;

use App\Tag;
use App\Type;
use App\User;
use App\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        //
    }

    /**
     * @return void
     */
    public function testBelongsToUser()
    {
        $record = factory(Record::class)->make([
            'user_id' => factory(User::class)->create()->id,
            'type_id' => factory(Type::class)->create()->id,
        ]);

        $this->assertEquals(1, $record->user()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToType()
    {
        $record = factory(Record::class)->make([
            'user_id' => factory(User::class)->create()->id,
            'type_id' => factory(Type::class)->create()->id,
        ]);

        $this->assertEquals(1, $record->type()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToManyTags()
    {
        $record = factory(Record::class)->make([
            'type_id' => factory(Type::class)->create()->id,
        ]);
        
        $tags = factory(Tag::class, 10)->make();

        $user = factory(User::class)->create();
        $user->records()->save($record);
        $user->tags()->saveMany($tags);

        $tags->each(
            function ($tag) use ($record) {
                $record->tags()->attach($tag->id);
            }
        );

        $this->assertEquals(10, $record->tags()->count());
    }
}
