<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerPlayer;

class SoccerPlayerSearchConfirmedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_player_confirmed(): void
    {
        SoccerPlayer::factory([
            'confirmed' => true
        ])->count(5)->create();

        $response = $this->get('/api/soccer/player/search/confirmed');
        $response->assertStatus(200);
        $response->assertJson(fn ($json) =>
        $json->where('data', fn ($data) => $data->count() > 0)
             ->etc()
        );
    }
}
