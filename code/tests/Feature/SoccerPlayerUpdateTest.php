<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerPlayer;

class SoccerPlayerUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_player_update(): void
    {
        SoccerPlayer::factory()->count(1)->create();

        $response = $this->post('/api/soccer/player/update/1', [
            'name' => 'roberto',
            'skill_level' => 2,
            'goalkeeper' => false
        ]);
        $response->assertStatus(200);
    }

    public function test_api_soccer_player_store_unprocessable(): void
    {
        SoccerPlayer::factory()->count(1)->create();
        $invalidData = [
            'name' => '',
            'skill_level' => 11,
            'goalkeeper' => 'not_a_boolean',
        ];

        $response = $this->postJson('api/soccer/player/update/1', $invalidData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'skill_level', 'goalkeeper']);
    }
}
