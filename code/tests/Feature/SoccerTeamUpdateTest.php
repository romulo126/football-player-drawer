<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerPlayer;
use App\Models\SoccerTeam;

class SoccerTeamUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_update_store(): void
    {
        SoccerTeam::factory([
            'players' => 1
        ])->count(1)->create();
        SoccerPlayer::factory([
            'confirmed' => true
        ])->count(4)->create();

        $response = $this->postJson('/api/soccer/team/update/1', [
            'name' => 'azul',
            'players' => 2,
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Time atualizado'
        ]);
    }

    public function test_api_soccer_team_update_unprocessable(): void
    {
        SoccerTeam::factory([
            'players' => 1
        ])->count(1)->create();
        SoccerPlayer::factory([
            'confirmed' => true
        ])->count(4)->create();
        $invalidData = [
            'players' => 11,
        ];
        $response = $this->postJson('/api/soccer/team/update/1', $invalidData);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['players']);
    }
}
