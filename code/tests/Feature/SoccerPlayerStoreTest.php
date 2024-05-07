<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SoccerPlayerStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_player_store(): void
    {
        $response = $this->post('/api/soccer/player/store', [
            'name' => 'roberto',
            'skill_level' => 2,
            'goalkeeper' => false
        ]);
        $response->assertStatus(200);
        $response->assertJson(fn ($json) =>
        $json->where('data', fn ($data) => $data->count() > 0)
             ->etc()
        );
    }

    public function test_api_soccer_player_store_unprocessable(): void
    {
        $invalidData = [
            'name' => '',
            'skill_level' => 11,
            'goalkeeper' => 'not_a_boolean',
        ];

        $response = $this->postJson('/api/soccer/player/store', $invalidData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'skill_level', 'goalkeeper']);
    }
}
