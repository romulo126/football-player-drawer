<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSoccerTeamRequest;
use App\Services\SoccerTeamService;
use Exception;
use Illuminate\Http\JsonResponse;

class UpdateSoccerTeamController extends Controller
{
    private SoccerTeamService $soccerTeamService;

    public function __construct(SoccerTeamService $soccerTeamService)
    {
        $this->soccerTeamService = $soccerTeamService;
    }

    public function __invoke(int $id, UpdateSoccerTeamRequest $request): JsonResponse
    {
        try {
            $menssage = "Erro ao atualizar";

            if ($this->soccerTeamService->update($request->validated(), $id)) {
                $menssage = "Time atualizado";
            }

            return response()->json(['message' => $menssage]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
