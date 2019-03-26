<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SearchServiceInterface;

/**
 * @group Search
 */
class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchServiceInterface $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Search products
     * Get All available products
     *
     * @queryParam product_title required string title of product
     * @queryParam game_id required integer game_id of product
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @queryParam sort required string [newest, low-price, high-price, rating, review]
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     *      "products":
     *      [{
     *          "id": "5bceaa5139012",
     *          "title": "Wow wow",
     *          "game_id": 1,
     *          "description": "Good for your life",
     *          "delivery_method": 0,
     *          "view_count": 0,
     *          "user_id": 1,
     *          "published_date": "2018-10-23 04:57:53",
     *          "buy_now_price": "500.00",
     *          "expired_date": "2018-10-23 04:57:53",
     *          "status": 0
     *      }]
     * }
     */
    public function search(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $productTitle = $request->query('product_title') ?? '';
        $gameId = $request->query('game_id') ?? 0;
        $lowPrice = $request->query('low_price') ?? 0;
        $highPrice = $request->query('high_price') ?? 1000000;
        $rating = $request->query('rating') ?? null;
        $delivery = $request->query('delivery_method') ?? null;
        $sortMode = $request->query('sort') ?? null;

        $conditions = [
            'game_id' => $gameId,
            'title' => $productTitle,
            'rating' => $rating,
            'low_price' => $lowPrice,
            'high_price' => $highPrice,
            'delivery_method' => $delivery,
            'sort_mode' => $sortMode,
        ];

        $responseData = $this->searchService->search($conditions, $perPage);
        return response()->json($responseData, 200);
    }

    /**
     * Search Request buy
     * Get All available request buying
     *
     * @queryParam title required string title of request
     * @queryParam game_id required integer game_id of request
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @queryParam min_price required double minimun range price of request
     * @queryParam max_price required double maximum range price of request
     * @queryParam sort required string [newest, low-price, high-price]
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     *      "products":
     *      [{
     *          "id": "5bceaa5139012",
     *          "title": "Wow wow",
     *          "game_id": 1,
     *          "description": "Good for your life",
     *          "delivery_method": 0,
     *          "view_count": 0,
     *          "user_id": 1,
     *          "published_date": "2018-10-23 04:57:53",
     *          "buy_now_price": "500.00",
     *          "expired_date": "2018-10-23 04:57:53",
     *          "status": 0
     *      }]
     * }
     */
    public function searchRequestBuying(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $title = $request->query('title') ?? '';
        $gameId = $request->query('game_id') ?? 0;
        $minPrice = $request->query('min_price') ?? 0;
        $maxPrice = $request->query('max_price') ?? 1000000;
        $sortMode = $request->query('sort') ?? null;

        $conditions = [
            'game_id' => $gameId,
            'title' => $title,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'sort_mode' => $sortMode,
        ];

        $responseData = $this->searchService->searchRequestBuying($conditions, $perPage);
        return response()->json($responseData, 200);
    }
}
