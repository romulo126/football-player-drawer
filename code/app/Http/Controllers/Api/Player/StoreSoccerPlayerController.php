<?php

namespace App\Http\Controllers\Api\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSoccerPlayerRequest;
use App\Services\SoccerPlayerService;
use Exception;
use Illuminate\Http\JsonResponse;

class StoreSoccerPlayerController extends Controller
{
    private SoccerPlayerService $soccerPlayerService;

    public function __construct(SoccerPlayerService $soccerPlayerService)
    {
        $this->soccerPlayerService = $soccerPlayerService;
    }

    public function __invoke(StoreSoccerPlayerRequest $request): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Jogador criado com sucesso!',
                'data' => $this->soccerPlayerService->create($request->validated())
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
