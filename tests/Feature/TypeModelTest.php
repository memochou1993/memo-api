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

    protected $user;

    protected $type;

    protected $record;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->type = factory(Type::class)->create();

        $this->record = factory(Record::class)->create([
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
        ]);
    }

    /**
     * @return void
     */
    public function testHasManyRecords()
    {
        $type = $this->type;

        $this->assertEquals(1, $type->records()->count());
    }
}
