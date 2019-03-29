<?php

namespace Tests\Feature\Api\User;

use App\Tag;
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

    protected $record;

    protected $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->type = factory(Type::class)->create();

        $this->record = factory(Record::class)->make([
            'private' => true,
            'user_id' => $this->user->id,
            'type_id' => $this->type->id,
        ]);

        $this->tag = factory(Tag::class)->create([
            'user_id' => $this->user->id,
        ]);

        Passport::actingAs($this->user);
    }

    public function testIndex()
    {
        $record = $this->record;
        $record->save();
        $record->tags()->sync($this->tag->id);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/me/records?relationships=type,tags"
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    collect($record)->except([
                        'user_id',
                        'type_id',
                    ])->keys()->merge([
                        'type',
                        'tags',
                    ])->toArray(),
                ],
                'links',
                'meta',
            ]);
    }

    public function testStore()
    {
        $record = $this->record;

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(
            "/api/users/me/records?relationships=type,tags",
            collect($record)->merge([
                'tag_ids' => [
                    $this->tag->id,
                ],
            ])->toArray()
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => collect($record)->except([
                    'user_id',
                    'type_id',
                ])->keys()->merge([
                    'type',
                    'tags',
                ])->toArray(),
            ]);
    }

    public function testShow()
    {
        $record = $this->record;
        $record->save();
        $record->tags()->sync($this->tag->id);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/me/records/{$record->id}?relationships=type,tags"
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => collect($record)->except([
                    'user_id',
                    'type_id',
                ])->keys()->merge([
                    'type',
                    'tags',
                ])->toArray(),
            ]);
    }

    public function testUpdate()
    {
        $record = $this->record;
        $record->save();
        $record->tags()->sync($this->tag->id);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->patch(
            "/api/users/me/records/{$record->id}?relationships=type,tags",
            collect($record)->merge([
                'tag_ids' => [
                    $this->tag->id,
                ],
            ])->toArray()
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => collect($record)->except([
                    'user_id',
                    'type_id',
                ])->keys()->merge([
                    'type',
                    'tags',
                ])->toArray(),
            ]);
    }

    public function testDestroy()
    {
        $record = $this->record;
        $record->save();
        $record->tags()->sync($this->tag->id);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->delete(
            "/api/users/me/records/{$record->id}"
        );

        $response
            ->assertStatus(204);
    }
}
