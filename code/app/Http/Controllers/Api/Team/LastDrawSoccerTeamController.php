<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use App\Services\SoccerTeamService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class LastDrawSoccerTeamController extends Controller
{
    private SoccerTeamService $soccerTeamService;

    public function __construct(SoccerTeamService $soccerTeamService)
    {
        $this->soccerTeamService = $soccerTeamService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $response = Cache::get("last_draw");

            if (! $response) {
                return response()->json(['data' => [], "message" => "não ouve sorteio"]);
            }

            return response()->json(['data' => $this->soccerTeamService->drawPlayers()]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
