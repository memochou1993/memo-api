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
        $records = factory(Record::class, 10)->make();

        $user = factory(User::class)->create();
        $user->each(
            function ($user) use ($records) {
                $user->records()->saveMany($records);
            }
        );

        $this->assertEquals(10, $user->records()->count());
    }

    /**
     * @return void
     */
    public function testHasManyTags()
    {
        $tags = factory(Tag::class, 10)->make();

        $user = factory(User::class)->create();
        $user->each(
            function ($user) use ($tags) {
                $user->tags()->saveMany($tags);
            }
        );

        $this->assertEquals(10, $user->tags()->count());
    }
}
