<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use App\Services\SoccerTeamService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class DrawSoccerTeamController extends Controller
{
    private SoccerTeamService $soccerTeamService;

    public function __construct(SoccerTeamService $soccerTeamService)
    {
        $this->soccerTeamService = $soccerTeamService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $data = $this->soccerTeamService->drawPlayers();
            $lifeTime = 3600 * 6;
            Cache::remember("last_draw", $lifeTime, function () use($data){
                return $data;
            });

            return response()->json(['data' => $data]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
