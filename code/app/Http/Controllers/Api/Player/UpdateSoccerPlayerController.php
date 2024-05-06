<?php

namespace App\Http\Controllers\Api\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSoccerPlayerRequest;
use App\Services\SoccerPlayerService;
use Exception;
use Illuminate\Http\JsonResponse;

class UpdateSoccerPlayerController extends Controller
{
    private SoccerPlayerService $soccerPlayerService;

    public function __construct(SoccerPlayerService $soccerPlayerService)
    {
        $this->soccerPlayerService = $soccerPlayerService;
    }

    public function __invoke(int $id, UpdateSoccerPlayerRequest $request): JsonResponse
    {
        try {
            return response()->json(['data' => $this->soccerPlayerService->update($request->validated(), $id)]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
