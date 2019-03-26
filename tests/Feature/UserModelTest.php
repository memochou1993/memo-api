<?php

namespace Tests\Feature;

use App\Tag;
use App\Type;
use App\User;
use App\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
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
    public function testHasManyRecords()
    {
        $records = factory(Record::class, config('seeds.record.number'))->make();

        factory(User::class, 1)->create()->each(
            function ($user) use ($records) {
                $user->records()->saveMany($records);
            }
        );

        $records = User::find(config('default.user.id'))->records()->get();

        $this->assertCount(config('seeds.record.number'), $records->toArray());
    }

    /**
     * @return void
     */
    public function testHasManyTags()
    {
        $tags = factory(Tag::class, config('seeds.tag.number'))->make();

        factory(User::class, 1)->create()->each(
            function ($user) use ($tags) {
                $user->tags()->saveMany($tags);
            }
        );

        $tags = User::find(config('default.user.id'))->tags()->get();

        $this->assertCount(config('seeds.tag.number'), $tags->toArray());
    }
}
