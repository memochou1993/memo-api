<?php

namespace Tests\Feature;

use App\Type;
use App\User;
use App\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class, config('seeds.user.number'))->create();
    }

    /**
     * @return void
     */
    public function testHasManyRecords()
    {
        $records = factory(Record::class, 10)->make();

        $type = factory(Type::class)->create();
        $type->each(
            function ($type) use ($records) {
                $type->records()->saveMany($records);
            }
        );

        $this->assertEquals(10, $type->records()->count());
    }
}
