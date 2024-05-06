<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSoccerTeamRequest;
use App\Services\SoccerTeamService;
use Exception;
use Illuminate\Http\JsonResponse;

class StoreSoccerTeamController extends Controller
{
    private SoccerTeamService $soccerTeamService;

    public function __construct(SoccerTeamService $soccerTeamService)
    {
        $this->soccerTeamService = $soccerTeamService;
    }

    public function __invoke(StoreSoccerTeamRequest $request): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Time criado com sucesso!',
                'data' => $this->soccerTeamService->create($request->validated())
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
