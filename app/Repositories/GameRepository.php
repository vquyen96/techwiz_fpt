<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class GameRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Game';
    }

    public function getAllGame()
    {
        $columns = [
            'games.id',
            'games.category_id',
            'images.thumbnail_url',
            'images.picture_url',
            'games_lang.title',
            'games_lang.description',
            'games_lang.lang'
        ];
        return $this->model->join('games_lang', 'games.id', '=', 'games_lang.game_id')
            ->leftJoin('images', 'games.image_id', '=', 'images.id')
            ->get($columns);
    }

    public function getAllGameLang($lang)
    {
        $columns = [
            'games.id',
            'games.category_id',
            'images.thumbnail_url',
            'images.picture_url',
            'games_lang.title',
            'games_lang.description',
            'games_lang.lang'
        ];
        return $this->model->join('games_lang', 'games.id', '=', 'games_lang.game_id')
            ->leftJoin('images', 'games.image_id', '=', 'images.id')
            ->where('games_lang.lang', $lang)
            ->get($columns);
    }

    public function search($search, $count, $lang)
    {
        $columns = [
            'games.id',
            'games.category_id',
            'images.thumbnail_url',
            'images.picture_url',
            'games_lang.title',
            'games_lang.description',
            'games_lang.lang',
            'games.created_at'
        ];
        return $this->model->join('games_lang', 'games.id', '=', 'games_lang.game_id')
            ->leftJoin('images', 'games.image_id', '=', 'images.id')
            ->where(function ($query) use ($search) {
                $query
                    ->where('games_lang.description', 'like', '%'.$search.'%')
                    ->orWhere('games_lang.title', 'like', '%'.$search.'%');
            })
            ->where('games_lang.lang', $lang)
            ->orderByDesc('games.created_at')
            ->paginate($count, $columns);
    }

    public function getDetail($id)
    {
        $columnsEn = [
            'games.id',
            'images.thumbnail_url',
            'games.category_id',
            'images.picture_url',
            \DB::raw('games_lang.id AS id_en'),
            \DB::raw('games_lang.title AS title_en'),
            \DB::raw('games_lang.description AS description_en'),
        ];
        $game =  $this->model->join('games_lang', 'games.id', '=', 'games_lang.game_id')
            ->leftJoin('images', 'games.image_id', '=', 'images.id')
            ->where('games.id', $id)
            ->where('games_lang.lang', 'en')
            ->first($columnsEn);

        $columnsJa = [
            \DB::raw('games_lang.id AS id_ja'),
            \DB::raw('games_lang.title AS title_ja'),
            \DB::raw('games_lang.description AS description_ja'),
        ];
        $gameJa =  $this->model->join('games_lang', 'games.id', '=', 'games_lang.game_id')
            ->where('games_lang.lang', 'ja')
            ->where('games.id', $id)
            ->first($columnsJa);
        $game->id_ja = $gameJa->id_ja;
        $game->title_ja = $gameJa->title_ja;
        $game->description_ja = $gameJa->description_ja;

        return $game;
    }
}
