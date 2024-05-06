<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use App\Services\SoccerTeamService;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteSoccerTeamController extends Controller
{
    private SoccerTeamService $soccerTeamService;

    public function __construct(SoccerTeamService $soccerTeamService)
    {
        $this->soccerTeamService = $soccerTeamService;
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            return response()->json(['data' => $this->soccerTeamService->delete($id)]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
