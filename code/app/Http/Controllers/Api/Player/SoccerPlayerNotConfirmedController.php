<?php

namespace App\Http\Controllers\Api\Player;

use App\Http\Controllers\Controller;
use App\Services\SoccerPlayerService;
use Exception;
use Illuminate\Http\JsonResponse;

class SoccerPlayerNotConfirmedController extends Controller
{
    private SoccerPlayerService $soccerPlayerService;

    public function __construct(SoccerPlayerService $soccerPlayerService)
    {
        $this->soccerPlayerService = $soccerPlayerService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            return response()->json(['data' => $this->soccerPlayerService->getNotConfirmedPlayers()]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
