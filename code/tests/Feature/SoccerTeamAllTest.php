<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerTeam;

class SoccerTeamAllTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @teste
     */
    public function test_api_soccer_all_team(): void
    {
        SoccerTeam::factory()->count(5)->create();

        $response = $this->get('/api/soccer/team/');
        $response->assertStatus(200);
        $response->assertJson(fn ($json) =>
        $json->where('data', fn ($data) => $data->count() > 0)
             ->etc()
        );
    }
}
