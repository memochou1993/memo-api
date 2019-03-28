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

        //
    }

    /**
     * @return void
     */
    public function testHasManyRecords()
    {
        $records = factory(Record::class, 10)->make([
            'type_id' => factory(Type::class)->create()->id,
        ]);

        $user = factory(User::class)->create();
        $user->records()->saveMany($records);

        $this->assertEquals(10, $user->records()->count());
    }

    /**
     * @return void
     */
    public function testHasManyTags()
    {
        $tags = factory(Tag::class, 10)->make();

        $user = factory(User::class)->create();
        $user->tags()->saveMany($tags);

        $this->assertEquals(10, $user->tags()->count());
    }
}
