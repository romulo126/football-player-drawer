<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerPlayer;

class SoccerTeamStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_team_store(): void
    {
        SoccerPlayer::factory([
            'confirmed' => true
        ])->count(4)->create();

        $response = $this->post('/api/soccer/team/store', [
            'name' => 'azul',
            'players' => 2,
        ]);
        $response->assertStatus(200);
        $response->assertJson(fn ($json) =>
        $json->where('data', fn ($data) => $data->count() > 0)
             ->etc()
        );
    }

    public function test_api_soccer_team_store_unprocessable(): void
    {
        SoccerPlayer::factory([
            'confirmed' => true
        ])->count(4)->create();
        $invalidData = [
            'players' => 11,
        ];

        $response = $this->postJson('/api/soccer/team/store', $invalidData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['players']);
    }
}
