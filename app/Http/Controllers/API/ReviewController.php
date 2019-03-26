<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReviewServiceInterface;
use App\Http\Requests\Review\AddReviewRequest;

/**
 * @group Review
 */
class ReviewController extends Controller
{
    private $reviewService;

    public function __construct(ReviewServiceInterface $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Create User Review
     *
     * @param AddReviewRequest $request
     * @return \Illumincate\Http\JsonResponse
     *
     * @bodyParam user_id unsigned_integer required id of reviewing user
     * @bodParam rating unsigned_integer required star rating
     * @bodyParam content string required  review content
     *
     * @response {
     *  "review": {
     *    "user_id": 2,
     *    "rating": 5,
     *    "content": "Good boy",
     *    "reviewer_id": 1,
     *    "updated_at": "2018-12-07 02:56:38",
     *    "created_at": "2018-12-07 02:56:38",
     *    "id": 1
     *  }
     * }
     */
    public function create(AddReviewRequest $request)
    {
        $reviewRequestData = $request->all();
        $reviewResponseData = $this->reviewService->create($reviewRequestData);
        return response()->json($reviewResponseData, 201);
    }

    /**
     * GET List Reviews
     *
     * @param Request $request
     * @return \Illumincate\Http\JsonResponse
     *
     * @bodyParam id unsigned_integer required user id
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @queryParam filter string [all, good, normal, bad] filter review content
     * @response {
     *  "reviews": {
     *      "current_page: "1",
     *      "data": [
     *          {
     *             "id": "2",
     *             "reviewer_id": 1,
     *             "name": "hoangpt",
     *             "avatar_url": "",
     *             "rating": 2.00,
     *             "content": "content",
     *             "created_at": "2018-12-07 02:42:07"
     *          }
     *      ]
     *   }
     * }
     *
     */

    public function getReviews(Request $request)
    {
        $userId = $request->id;
        $perPage = $request->query('count') ?? 10;
        $mode = $request->query('filter') ?? 'all';
        $responseData = $this->reviewService->getReviews($userId, $perPage, $mode);
        return response()->json($responseData, 200);
    }
}
