<?php

namespace Tests\Feature\Api;

use App\Tag;
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

        $this->tag = factory(Tag::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    public function testIndex()
    {
        $record = factory(Record::class)->create([
            'private' => false,
            'user_id' => $this->user->id,
        ]);
        $record->tags()->sync($this->tag->id);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/{$this->user->id}/records?with=tags"
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    collect($record)->except([
                        'user_id',
                    ])->keys()->merge([
                        'tags',
                    ])->toArray(),
                ],
                'links',
                'meta',
            ]);
    }

    public function testShow()
    {
        $record = factory(Record::class)->create([
            'private' => false,
            'user_id' => $this->user->id,
        ]);
        $record->tags()->sync($this->tag->id);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/{$this->user->id}/records/{$record->id}?with=tags"
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => collect($record)->except([
                    'user_id',
                ])->keys()->merge([
                    'tags',
                ])->toArray(),
            ]);
    }

    public function testCannotViewPrivate()
    {
        $record = factory(Record::class)->create([
            'private' => true,
            'user_id' => $this->user->id,
        ]);
        $record->tags()->sync($this->tag->id);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get(
            "/api/users/{$this->user->id}/records/{$record->id}"
        );

        $response
            ->assertStatus(404);
    }
}
