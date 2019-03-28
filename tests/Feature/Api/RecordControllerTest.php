<?php

namespace Tests\Feature\Api;

use App\Type;
use App\User;
use App\Record;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        Type::insert(config('factories.type'));
    }

    public function testIndex()
    {
        $user = $this->user;

        $record = factory(Record::class)->make([
            'private' => false,
        ]);

        $user->records()->save($record);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/{$user->id}/records"
        );

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => [
                    collect($record)->except([
                        'user_id',
                        'type_id',
                    ])->keys()->toArray(),
                ],
                'links',
                'meta',
            ]);
    }

    public function testShow()
    {
        $user = $this->user;

        $record = factory(Record::class)->make([
            'private' => false,
        ]);

        $user->records()->save($record);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/{$user->id}/records/{$record->id}"
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => collect($record)->except([
                    'user_id',
                    'type_id',
                ])->keys()->toArray(),
            ]);
    }

    public function testCannotViewPrivate()
    {
        $user = $this->user;

        $record = factory(Record::class)->make([
            'private' => true,
        ]);

        $user->records()->save($record);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/{$user->id}/records/{$record->id}"
        );

        $response
            ->assertStatus(404);
    }
}
