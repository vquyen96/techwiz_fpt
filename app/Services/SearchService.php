<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\RequestRepository;

class SearchService implements SearchServiceInterface
{
    private $productRepository;
    private $requestRepository;

    public function __construct(
        ProductRepository $productRepository,
        RequestRepository $requestRepository
    ) {
        $this->productRepository = $productRepository;
        $this->requestRepository = $requestRepository;
    }

    /**
     * Search
     *
     * @return array products
     */
    public function search($conditions, $perPage)
    {
        $products = $this->productRepository
            ->with(['images'])
            ->search($conditions, $perPage);
        return [
            'total_result' => $products->total(),
            'products' => $products->all(),
        ];
    }

    public function searchRequestBuying($condition, $perPage)
    {
        $requests = $this->requestRepository
                    ->with(['images'])
                    ->search($condition, $perPage);
        return [
            'total_result' => $requests->total(),
            'requests' => $requests->all(),
        ];
    }
}
