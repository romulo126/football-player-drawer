<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerPlayer;

class SoccerPlayerDeletTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_player_delet(): void
    {
        SoccerPlayer::factory()->count(1)->create();

        $response = $this->delete('/api/soccer/player/delete/1');
        $response->assertStatus(200);
    }
}
