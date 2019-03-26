<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ReviewRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Review';
    }

    public function getReviews($id, $perPage, $filter, $column = array('*'))
    {
        $ordering = 'DESC';
        $query = $this->model
            ->join('users', 'reviews.reviewer_id', '=', 'users.id')
            ->where('user_id', $id);
        $queryWithFilter = $this->applyFilter($query, $filter);

        return $queryWithFilter
                ->orderBy("reviews.created_at", $ordering)
                ->paginate($perPage, $column);
    }

    private function applyFilter($query, $filter)
    {
        $filterQuery = $query;

        switch (strtolower($filter)) {
            case 'good':
                $filterQuery = $query
                        ->where('reviews.rating', '>=', 4);
                break;
            case 'normal':
                $filterQuery = $query
                        ->where('reviews.rating', '>=', 2)
                        ->where('reviews.rating', '<', 4);
                break;
            case 'bad':
                $filterQuery = $query
                        ->where('reviews.rating', '>=', 1)
                        ->where('reviews.rating', '<', 2);
                break;
            case 'all':
            default:
                break;
        }

        return $filterQuery;
    }
}
