<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use Carbon\Carbon;
use App\Enums\Products\Status as ProductStatus;

class ProductRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Product';
    }

    private function applySort($query, $sortMode)
    {
        $sortedQuery = $query;
        switch ($sortMode) {
            case "newest":
                $sortedQuery = $sortedQuery->orderBy(
                    'published_date',
                    'DESC'
                );
                break;
            case "low-price":
                $sortedQuery = $sortedQuery->orderBy(
                    'buy_now_price',
                    'ASC'
                );
                break;
            case "high-price":
                $sortedQuery = $sortedQuery->orderBy(
                    'buy_now_price',
                    'DESC'
                );
                break;
            case "rating":
                $sortedQuery = $sortedQuery->orderBy(
                    'users.rating',
                    'DESC'
                )->orderBy(
                    'published_date',
                    'DESC'
                );
                break;
            case "review":
                $sortedQuery = $sortedQuery->orderBy(
                    'users.review_count',
                    'DESC'
                )->orderBy(
                    'published_date',
                    'DESC'
                );
                break;
            default:
                break;
        }

        return $sortedQuery;
    }

    public function getNew($perPage, $orderColumn, $column = array('*'))
    {
        $ordering = 'DESC';
        return $this->model
            ->where('status', ProductStatus::PUBLISH)
            ->orderBy($orderColumn, $ordering)
            ->paginate($perPage, $column);
    }

    public function getListing($userId, $statusArray, $perPage)
    {
        $columns = [
            'products.id',
            'title',
            'game_id',
            'description',
            'delivery_method',
            'view_count',
            'buy_now_price',
            \DB::raw('products.status AS product_status'),
            \DB::raw('buyings.status AS buying_status'),
            'published_date',
            'products.created_at',
            'expired_date',
        ];

        $ordering = 'DESC';
        return $this->model->leftJoin('buyings', 'products.id', '=', 'buyings.product_id')
            ->where('products.user_id', $userId)
            ->whereIn('products.status', $statusArray)
            ->orderBy('published_date', $ordering)
            ->paginate($perPage, $columns);
    }

    public function getPurchase($userId, $statusArray, $perPage)
    {
        $columns = [
            'products.id',
            'title',
            'game_id',
            'description',
            'delivery_method',
            'view_count',
            'buy_now_price',
            \DB::raw('products.status AS product_status'),
            \DB::raw('buyings.status AS buying_status'),
            'published_date',
            'products.created_at',
            'expired_date',
        ];

        $ordering = 'DESC';
        return $this->model->join('buyings', 'products.id', '=', 'buyings.product_id')
            ->where('buyings.user_id', $userId)
            ->whereIn('products.status', $statusArray)
            ->orderBy('published_date', $ordering)
            ->paginate($perPage, $columns);
    }

    public function search($conditions, $perPage)
    {
        $gameId = $conditions['game_id'];
        $productTitle = $conditions['title'] ?? '';
        $rating = $conditions['rating'];
        $lowPrice = $conditions['low_price'];
        $highPrice = $conditions['high_price'];
        $deliveryMethod = $conditions['delivery_method'];
        $sortMode = $conditions['sort_mode'];

        $gameIdWhereClause = 'game_id > 0';
        if ($gameId > 0) {
            $gameIdWhereClause = 'game_id = ' . $gameId;
        }
        $columns = [
            'products.id',
            'products.title',
            'products.game_id',
            'products.description',
            'products.delivery_method',
            'products.view_count',
            'products.user_id',
            'products.published_date',
            'products.buy_now_price',
            'products.expired_date',
            'products.status',
            'users.rating',
            'users.review_count',
        ];

        $query = $this->model
                    ->join('users', 'products.user_id', '=', 'users.id');
        
        if ($rating !== null) {
            $query = $query->where('users.rating', '>=', $rating);
        }
        if ($deliveryMethod !== null) {
            $query = $query->where('products.delivery_method', '=', $deliveryMethod);
        }

        $query = $query->where('status', ProductStatus::PUBLISH)
                        ->whereBetween('products.buy_now_price', [$lowPrice, $highPrice])
                        ->where('title', 'like', '%' . $productTitle . '%')
                        ->whereRaw($gameIdWhereClause);

        $query = $this->applySort($query, $sortMode);
        return $query->paginate($perPage, $columns);
    }

    public function searchList($search, $status, $game)
    {
        $productSearch = $this->model;
        if (isset($search)) {
            //get categories like search
            $categoryIds = \DB::table('categories_lang')
                ->where('title', 'like', '%'.$search.'%')
                ->where('lang', 'en')->get(['category_id'])
                ->toArray();
            $categoryIds = array_column(json_decode(json_encode($categoryIds), true), 'category_id');

            //get games by categories
            $gameIds = \DB::table('games')->whereIn('category_id', $categoryIds)->get(['id'])->toArray();
            $gameIds = array_column(json_decode(json_encode($gameIds), true), 'id');

            //get product by games and search
            $productSearch = $productSearch->where(function ($query) use ($search, $gameIds) {
                $query
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhereIn('game_id', $gameIds)
                    ->orWhere('id', 'like', $search);
            });
        }
        if (isset($status)) {
            $productSearch = $productSearch->where('status', '=', $status);
        }
        if (isset($game)) {
            $productSearch = $productSearch->where('game_id', '=', $game);
        }

        return $productSearch;
    }

    public function getExpired()
    {
        $timeNow = Carbon::now();
        return $this->model->where('expired_date', '<', $timeNow)
            ->where('status', ProductStatus::PUBLISH)->get();
    }

    public function updateStatus($product, $status)
    {
        return $product->update(['status' => $status]);
    }

    public function getBuyingSuccess()
    {
        $columns = [
            'products.id',
            'title',
            'game_id',
            'description',
            'delivery_method',
            'view_count',
            'buy_now_price',
            \DB::raw('products.status AS product_status'),
            \DB::raw('buyings.status AS buying_status'),
            'published_date',
            'products.created_at',
            'expired_date',
            \DB::raw('buyings.created_at AS buying_at'),
            'buyings.remind_receive'
        ];
        $timeNow = Carbon::now();
        $buyings =  $this->model->join('buyings', 'products.id', '=', 'buyings.product_id')
            ->where('products.status', ProductStatus::SELLING_SUCCESS)
            ->where('buyings.created_at', '<=', $timeNow)
            ->get($columns);
        foreach ($buyings as $buying) {
            $buyingAt = new Carbon($buying->buying_at);
            $timeDelivery = $buyingAt->addDays($buying->delivery_method + 1);
            if ($timeDelivery <= $timeNow && $buying->remind_receive == 0) {
                $buying->noti = true;
            }
            $timeReceived = $buyingAt->addDays(1);
            if ($timeReceived < $timeNow) {
                $buying->received = true;
            }
        }
        return $buyings;
    }
}
