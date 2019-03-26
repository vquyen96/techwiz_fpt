<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RequestBuyingServiceInterface;

/**
 * @group Request Buying
 */
class RequestBuyingController extends Controller
{
    private $requestBuyingService;

    public function __construct(
        RequestBuyingServiceInterface $requestBuyingService
    ) {
        $this->requestBuyingService = $requestBuyingService;
    }

    /**
     * Create Request
     * Create a new Request Buying
     *
     * @bodyParam title required string title of ticket
     * @bodyParam description required string content of what you wanna report
     * @bodyParam images required string list image id 1|2|3
     * @bodyParam game_id required integer id of game
     * @bodyParam min_price required decimal minimum price
     * @bodyParam max_price required decimal maximum price
     * @bodyParam expiration required integer expiration days: 1 day, 7 days,...
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * }
     */
    public function create(Request $request)
    {
        $requestData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'game_id' => 'required|exists:games,id',
            'min_price' => 'required|numeric|between:1,9999999999999,99',
            'max_price' => 'required|numeric|between:1,9999999999999,99',
            'expiration' => 'required|integer',
            'images' => [
                'present',
                'nullable',
                'string',
                'regex:/[0-9\|]*$/',
            ],
        ]);
        $imagesData = $request->input('images');

        $responseData = $this->requestBuyingService->create($requestData, $imagesData);
        return response()->json($responseData, 201);
    }

    /**
     * Request Buying Detail
     * Show request buying detail
     *
     * @queryParam id string id of showing request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * "request_buying": {
     *  "id": "5c872e793c84b",
     *  "title": "Buy YugiOh Card",
     *  "game_id": 1,
     *  "description": "I wanna let it go",
     *  "min_price": "10.10",
     *  "max_price": "20.20",
     *  "expired_date": null,
     *  "status": 0,
     *  "user_id": "5c80a11f7a963",
     *  "created_at": "2019-03-12 03:58:49",
     *  "updated_at": "2019-03-12 03:58:49",
     *  "is_owner": false,
     *  "images": [],
     *  "user": {
     *      "name": "RMT User",
     *      "avatar_url": "",
     *      "id": "5c80a11f7a963"
     *      }
     *    }
     *  }
     */
    public function show($id)
    {
        $responseData = $this->requestBuyingService->showDetail($id);
        return response()->json($responseData, 200);
    }

    /**
     * Stop Request Buying
     * User stop request buy item
     *
     * @queryParam id string id of stopping request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * "id": "5c872e793c84b",
     * "title": "Buy YugiOh Card",
     * "game_id": 1,
     * "description": "I wanna let it go",
     * "min_price": "10.10",
     * "max_price": "20.20",
     * "expired_date": null,
     * "status": 1,
     * "user_id": "5c80a11f7a963",
     * "created_at": "2019-03-12 03:58:49",
     * "updated_at": "2019-03-12 04:59:40"
     * }
     */
    public function stopRequest(Request $request)
    {
        $requestId = $request->route('id');

        $responseData = $this->requestBuyingService->stopRequest($requestId);

        return response()->json($responseData, 200);
    }

    /**
     * Update Request Buying
     * Update current Request buying
     *
     * @bodyParam title required string title of ticket
     * @bodyParam description required string content of what you wanna report
     * @bodyParam game_id required integer id of game
     * @bodyParam min_price required decimal minimum price
     * @bodyParam max_price required decimal maximum price
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * "id": "5c872e793c84b",
     * "title": "Buy YugiOh Card",
     * "game_id": 1,
     * "description": "I wanna let it go",
     * "min_price": "10.10",
     * "max_price": "20.20",
     * "expired_date": null,
     * "status": 1,
     * "user_id": "5c80a11f7a963",
     * "created_at": "2019-03-12 03:58:49",
     * "updated_at": "2019-03-12 04:59:40"
     * }
     */
    public function edit(Request $request, $requestId)
    {
        $requestData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string|max:65535',
            'game_id' => 'exists:games,id',
            'min_price' => 'numeric|between:1,9999999999999,99',
            'max_price' => 'numeric|between:1,9999999999999,99',
        ]);
        
        $requestImages = $request->input('images');
        $responseData = $this->requestBuyingService->update($requestId, $requestData, $requestImages);
        return response()->json($responseData, 200);
    }

    /**
     * Get List Request by Status
     * Get and filter Request buying by status
     *
     * @queryParam status required integer 0 = Open, 1 = close request
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * "requests": [
     *         {
     *             "id": "5c8736a572aa0",
     *             "title": "Buy YugiOh Card",
     *             "game_id": 1,
     *             "description": "I wanna let it go",
     *             "min_price": "10.10",
     *             "max_price": "20.20",
     *             "expired_date": "2019-03-13 04:33:41",
     *             "status": 0,
     *             "user_id": "5c80a11f7a963",
     *             "created_at": "2019-03-12 04:33:41",
     *             "updated_at": "2019-03-12 04:33:41",
     *             "images": []
     *         }
     *     ],
     *     "total_page": 2
     * }
     */
    public function list(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $status = $request->query('status') ?? 0;

        $responseData = $this->requestBuyingService->listing($status, $perPage);
        return response()->json($responseData, 200);
    }

    /**
     * My Requests
     * Get All of my requests
     *
     * @queryParam status required string all, open, close
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * "requests": [
     *         {
     *             "id": "5c8736a572aa0",
     *             "title": "Buy YugiOh Card",
     *             "game_id": 1,
     *             "description": "I wanna let it go",
     *             "min_price": "10.10",
     *             "max_price": "20.20",
     *             "expired_date": "2019-03-13 04:33:41",
     *             "status": 0,
     *             "user_id": "5c80a11f7a963",
     *             "created_at": "2019-03-12 04:33:41",
     *             "updated_at": "2019-03-12 04:33:41",
     *             "images": []
     *         }
     *     ],
     *     "total_page": 2
     * }
     */
    public function myRequests(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $status = $request->query('status') ?? 'all';

        $responseData = $this->requestBuyingService->myRequests($status, $perPage);
        return response()->json($responseData, 200);
    }
}
