<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NotificationServiceInterface;
use App\Http\Requests\Notification\ReadNotificationRequest;

/**
 * @group Notification
 */
class NotificationController extends Controller
{

    private $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get-Notification
     * Get notification list
     *
     * @param Request $request
     * @queryParam type required integer number for type of notification
     * @queryParam page required integer current page
     * @queryParam count required integer number of record each page
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *   "count_unread": 1,
     *   "notifications": [
     *      {
     *          "id": 1
     *          "Title": "You have won a bid",
     *          "Content": "Macbook pro 256G",
     *          "type": 1,
     *          "image_url": "https://hblab-rmt-test.s3.ap-northeast-1.amazonaws.com/picture-5bfdf46b15d42.jpeg",
     *          "path": "product/5bf3eadba3368",
     *          "status": 0,
     *          "created_at": "2018-11-27 03:33:35"
     *      }
     *   ]
     * }
     */
    public function getNotification(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $type = $request->query('type') ?? 0;
        $notifications = $this->notificationService->getNotification($type, $perPage);
        return response()->json($notifications, 200);
    }

    public function readNotification(ReadNotificationRequest $request)
    {
        $responseData = $this->notificationService->readNotification($request->input('id'));
        return response()->json($responseData, 200);
    }
}
