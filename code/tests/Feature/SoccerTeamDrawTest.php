<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerTeam;
use App\Models\SoccerPlayer;

class SoccerTeamDrawTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_draw_team(): void
    {
        SoccerTeam::factory([
            'players' => 2
        ])->count(2)->create();
        SoccerPlayer::factory([
            'confirmed' => true,
            'goalkeeper' => true
        ])->count(2)->create();
        SoccerPlayer::factory([
            'confirmed' => true,
            'goalkeeper' => false
        ])->count(2)->create();

        $response = $this->get('/api/soccer/team/draw');
        $response->assertStatus(200);
        $response->assertJson(fn ($json) =>
        $json->where('data', fn ($data) => $data->count() > 0)
             ->etc()
        );
    }
}
