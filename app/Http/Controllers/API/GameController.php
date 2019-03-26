<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\GameServiceInterface;

/**
 * @group game
 */
class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Get-All-Games
     * Get All available games
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     *      "games":
     *      {
     *          "en": [
     *              {
     *                  "id" : 1,
     *                  "category_id" : 1,
     *                  "image_id": 1
     *                  "title" : "LUC888",
     *                  "description": "LUC888",
     *                  "lang": "en",
     *              }
     *          ],
     *          "jp": [
     *              {
     *                  "id" : 1,
     *                  "category_id" : 1,
     *                  "image_id": 1
     *                  "title" : "LUC888",
     *                  "description": "LUC888",
     *                  "lang": "en",
     *              }
     *          ]
     *      }
     * }
     */
    public function index()
    {
        $responseData = $this->gameService->getAll();
        return response()->json($responseData, 200);
    }
}
