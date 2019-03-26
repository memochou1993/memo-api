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

        Type::insert(config('factories.type'));
    }

    /**
     * @return void
     */
    public function testBelongsToUser()
    {
        $tag = factory(Tag::class)->make();

        factory(User::class)->create()->each(
            function ($user) use ($tag) {
                $user->tags()->save($tag);
            }
        );

        $this->assertEquals(1, Tag::find(1)->user()->count());
    }

    /**
     * @return void
     */
    public function testBelongsToManyTags()
    {
        $tags = factory(Tag::class, 10)->make();
        
        $records = factory(Record::class, 10)->make();

        factory(User::class)->create()->each(
            function ($user) use ($tags, $records) {
                $user->tags()->saveMany($tags);
                $user->records()->saveMany($records);
            }
        );

        $tags->each(
            function ($tag) use ($records) {
                $records->each(
                    function ($record) use ($tag) {
                        $tag->records()->attach($record->id);
                    }
                );
            }
        );

        $this->assertEquals(10, Tag::find(1)->records()->count());
    }
}
