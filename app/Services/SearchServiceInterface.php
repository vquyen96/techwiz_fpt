<?php

namespace App\Services;

interface SearchServiceInterface
{
    public function search($conditions, $perPage);
    public function searchRequestBuying($condition, $perPage);
}
