<?php

namespace App\Services;

interface ReviewServiceInterface
{
    public function create($reviewData);
    public function getReviews($id, $perPage, $filter);
}
