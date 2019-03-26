<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ChattingServiceInterface;
use App\Services\NotificationServiceInterface;
use Illuminate\Http\Request;

/**
 * @group Chatting
 */
class ChattingController extends Controller
{
    protected $chattingService;
    protected $notificationService;

    public function __construct(
        ChattingServiceInterface $chattingService,
        NotificationServiceinterface $notificationService
    ) {
        $this->chattingService = $chattingService;
        $this->notificationService = $notificationService;
    }

    /**
     * Get-All-Messages
     * Get All available messages
     *
     * @bodyParam productId integer required id of product
     * @bodyParam count integer perPage
     * @bodyParam page integer current page
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     *      "messages":[
     *          {
     *              "user_id": 1,
     *              "name": "RMT Admin",
     *              "avatar_url" : "http://123.com/abc",
     *              "message": "Ngon ",
     *              "created_at": "2019-01-23 10:10:36"
     *          },
     *          {
     *              "user_id": 1,
     *              "name": "RMT Admin",
     *              "avatar_url" : "http://123.com/abc",
     *              "message": "Ngon ",
     *              "created_at": "2019-01-23 10:10:36"
     *          }
     *      ],
     *      "total_messages" : 5,
     *      "maximum_messages" : 15
     * }
     */
    public function list(Request $request)
    {
        $this->validationList($request);
        $productId = $request->query('productId');
        $perPage = $request->query('count') ?? 10;
        $page = $request->query('page') ?? 1;
        $responseData = $this->chattingService->list($productId, $perPage, $page);
        return response()->json($responseData, 200);
    }

    protected function validationList($request)
    {
        return $request->validate([
            'productId' => 'required',
            'count' => 'integer|min:1'
        ]);
    }

    /**
     * Send-Message
     * Send message
     *
     * @bodyParam product_id required string id of product
     * @bodyParam message string required message of user
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     *      "messages":"OK"
     * }
     */
    public function send(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'message' => 'required|string|max:1000',
        ]);
        $responseData = $this->chattingService->send(
            $validatedData['product_id'],
            $validatedData['message']
        );
        return response()->json($responseData, 201);
    }
}
