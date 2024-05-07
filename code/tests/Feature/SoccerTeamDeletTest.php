<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SoccerTeam;

class SoccerTeamDeletTest extends TestCase
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

        $response = $this->delete('/api/soccer/team/delete/1');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => true
        ]);
    }
}
