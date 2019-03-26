<?php

namespace App\Services;

use App\Repositories\GameRepository;

class GameService implements GameServiceInterface
{
    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * Get all categories
     *
     * @return array categories
     */
    public function getAll()
    {
        $allGames = $this->gameRepository->getAllGame();

        $groupGame = [];
        foreach ($allGames as $game) {
            if (!isset($groupGame[$game['lang']])) {
                $groupGame[$game['lang']] = [];
            }
            array_push(
                $groupGame[$game['lang']],
                (object) [
                    'id' => $game['id'],
                    'category_id' => $game['category_id'],
                    'thumbnail_url' => $game['thumbnail_url'],
                    'picture_url' => $game['picture_url'],
                    'title' => $game['title'],
                    'description' => $game['description'],
                    'lang' => $game['lang'],
                ]
            );
        }
    
        return [
            'games' => $groupGame,
        ];
    }
}
