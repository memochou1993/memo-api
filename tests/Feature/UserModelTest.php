<?php

namespace Tests\Feature;

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
        $records = factory(Record::class, 5)->make();

        factory(User::class, 1)->create()->each(
            function ($user) use ($records) {
                $user->records()->saveMany($records);
            }
        );

        $records = User::find(1)->records()->get();

        $this->assertCount(5, $records->toArray());
    }
}
