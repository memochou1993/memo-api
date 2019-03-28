<?php

namespace Tests\Feature;

use App\Tag;
use App\Type;
use App\User;
use App\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagModelTest extends TestCase
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
        $tag = factory(Tag::class)->create([
            'user_id' => factory(User::class)->create()->id,
        ]);

        $this->assertEquals(1, $tag->user()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToManyRecords()
    {
        $tag = factory(Tag::class)->make();

        $type = factory(Type::class)->create();

        $records = factory(Record::class, 10)->make([
            'type_id' => $type->id,
        ]);

        $user = factory(User::class)->create();
        $user->tags()->save($tag);
        $user->records()->saveMany($records);

        $records->each(
            function ($record) use ($tag) {
                $tag->records()->attach($record->id);
            }
        );

        $this->assertEquals(10, $tag->records()->count());
    }
}
