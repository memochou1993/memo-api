<?php

namespace Tests\Feature;

use App\Tag;
use App\User;
use App\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $record;

    protected $tag;

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
    }

    /**
     * @return void
     */
    public function testHasManyRecords()
    {
        $user = $this->user;

        $this->assertEquals(1, $user->records()->count());
    }

    /**
     * @return void
     */
    public function testHasManyTags()
    {
        $user = $this->user;

        $this->assertEquals(1, $user->tags()->count());
    }
}
