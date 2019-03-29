<?php

namespace Tests\Feature\Api\User;

use App\Type;
use App\User;
use App\Record;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $type;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->type = factory(Type::class)->create();

        Passport::actingAs($this->user);
    }

    public function testIndex()
    {
        $record = factory(Record::class)->create([
            'private' => true,
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/me/records"
        );

        $response
            ->assertStatus(200)
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

    public function testStore()
    {
        $record = factory(Record::class)->make([
            'private' => true,
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            "/api/users/me/records",
            $record->toArray()
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

    public function testShow()
    {
        $record = factory(Record::class)->create([
            'private' => true,
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/me/records/{$record->id}"
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

    public function testUpdate()
    {
        $record = factory(Record::class)->create([
            'private' => true,
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            "/api/users/me/records/{$record->id}",
            $record->toArray()
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

    public function testDestroy()
    {
        $record = factory(Record::class)->create([
            'private' => true,
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            "/api/users/me/records/{$record->id}"
        );

        $response
            ->assertStatus(204);
    }
}
