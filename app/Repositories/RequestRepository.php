<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use App\Enums\Request\Status as RequestStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RequestRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Request';
    }

    public function getListingRequest($status, $perPage)
    {
        return $this->model->where('status', $status)
                ->orderByDesc('created_at')
                ->paginate($perPage);
    }

    public function search($conditions, $perPage)
    {
        $gameId = $conditions['game_id'];
        $title = $conditions['title'] ?? '';
        $minPrice = $conditions['min_price'];
        $maxPrice = $conditions['max_price'];
        $sortMode = $conditions['sort_mode'];

        $gameIdWhereClause = 'game_id > 0';
        if ($gameId > 0) {
            $gameIdWhereClause = 'game_id = ' . $gameId;
        }

        $query = $this->model->where('status', RequestStatus::OPEN)
                            ->whereBetween('requests.min_price', [$minPrice, $maxPrice])
                            ->whereBetween('requests.max_price', [$minPrice, $maxPrice])
                            ->where('title', 'like', '%' . $title . '%')
                            ->whereRaw($gameIdWhereClause);
        $query = $this->applySort($query, $sortMode);
        return $query->paginate($perPage);
    }

    public function myRequests($status, $perPage)
    {
        $query = $this->model->where('user_id', Auth::id());
        $query = $this->applyFilterStatus($query, $status);
        return $query->orderByDesc('updated_at')
                    ->paginate($perPage);
    }

    private function applyFilterStatus($query, $status)
    {
        $filteringQuery = $query;
        switch ($status) {
            case "open":
                $filteringQuery = $filteringQuery
                    ->where('status', RequestStatus::OPEN);
                break;
            case "close":
                $filteringQuery = $filteringQuery
                    ->where('status', RequestStatus::CLOSED);
                break;
            case "all":
            default:
                break;
        }
        return $filteringQuery;
    }

    private function applySort($query, $sortMode)
    {
        $sortedQuery = $query;
        switch ($sortMode) {
            case "newest":
                $sortedQuery = $sortedQuery->orderByDesc('updated_at');
                break;
            case "low-price":
                $sortedQuery = $sortedQuery->orderBy(
                    'max_price',
                    'ASC'
                );
                break;
            case "high-price":
                $sortedQuery = $sortedQuery->orderByDesc('max_price');
                break;
            default:
                break;
        }

        return $sortedQuery;
    }

    public function searchAdmin($search, $status, $game, $count)
    {
        $colums = [
            'requests.id',
            \DB::raw('users.name AS username'),
            \DB::raw('users.avatar_url AS avatar_url'),
            'requests.title',
            'requests.game_id',
            'requests.min_price',
            'requests.max_price',
            'requests.created_at'
        ];

        $requestSearch =  $this->model->join('users', 'requests.user_id', '=', 'users.id');

        if (isset($search)) {
            $requestSearch->where(function ($query) use ($search) {
                $query
                    ->where('requests.title', 'like', '%'.$search.'%')
                    ->orWhere('requests.description', 'like', '%'.$search.'%')
                    ->orWhere('requests.id', 'like', '%'.$search.'%')
                    ->orWhere('users.id', 'like', '%'.$search.'%')
                    ->orWhere('users.name', 'like', '%'.$search.'%');
            });
        }
        if (isset($status)) {
            $requestSearch = $requestSearch->where('status', '=', $status);
        }
        if (isset($game)) {
            $requestSearch = $requestSearch->where('game_id', '=', $game);
        }
        return $requestSearch
            ->orderByDesc('requests.created_at')
            ->paginate($count, $colums);
    }

    public function getExpired()
    {
        $timeNow = Carbon::now();
        return $this->model->where('expired_date', '<', $timeNow)
            ->where('status', RequestStatus::OPEN)->get();
    }
}
