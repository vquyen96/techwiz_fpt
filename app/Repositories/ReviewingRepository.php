<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ReviewingRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Reviewing';
    }

    public function numberRemainingReview($userId, $reviewerId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('reviewer_id', $reviewerId)
            ->count();
    }

    public function getFirstReviewable($userId, $reviewerId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('reviewer_id', $reviewerId)
            ->first();
    }
}
