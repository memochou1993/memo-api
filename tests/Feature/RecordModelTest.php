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

        Type::insert(config('factories.type'));
    }

    /**
     * @return void
     */
    public function testBelongsToUser()
    {
        $record = factory(Record::class)->make();

        factory(User::class)->create()->each(
            function ($user) use ($record) {
                $user->records()->save($record);
            }
        );

        $this->assertEquals(1, Record::find(1)->user()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToType()
    {
        $record = factory(Record::class)->make();

        factory(User::class)->create()->each(
            function ($user) use ($record) {
                $user->records()->save($record);
            }
        );

        $this->assertEquals(1, Record::find(1)->type()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToManyTags()
    {
        $records = factory(Record::class, 10)->make();
        
        $tags = factory(Tag::class, 10)->make();

        factory(User::class)->create()->each(
            function ($user) use ($records, $tags) {
                $user->records()->saveMany($records);
                $user->tags()->saveMany($tags);
            }
        );

        $records->each(
            function ($record) use ($tags) {
                $tags->each(
                    function ($tag) use ($record) {
                        $record->tags()->attach($tag->id);
                    }
                );
            }
        );

        $this->assertEquals(10, Record::find(1)->tags()->count());
    }
}
