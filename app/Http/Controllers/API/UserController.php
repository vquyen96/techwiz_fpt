<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdatePaypalEmailRequest;

/**
 * @group User Detail
 */
class UserController extends Controller
{

    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * GET - User Info
     *
     *
     * @param Request $request
     * @queryParam user_id required user id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *  "user": {
     *    "id": 1,
     *    "name": "RMT Admin",
     *    "avatar_url": "",
     *    "description": "",
     *    "rating": 0,
     *    "created_at": "2018-12-07 02:42:07"
     *    "paypal_email": "rmt.hblab@gmail.com"
     *  },
     *  "buying_count":2
     * }
     */
    public function getUserInfo(Request $request)
    {
        $userId = $request->id;
        $responseData = $this->userService->getUserInfo($userId);
        return response()->json($responseData, 200);
    }

    /**
     * PUT - Update Paypal Email
     *
     *
     * @param UpdatePaypalEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam paypal_email string paypal_email of user
     *
     * @response {
     *    "id": 1,
     *    "name": "RMT Admin",
     *    "email": "rmt.hblab@gmail.com",
     *    "description": "0.48",
     *    "avatar_bucket": "",
     *    "avatar_name": "EH0TvUkQA4xt1-O3Bm6kkssFityw3LTZsXr3cqxSOq4GkUaaJbuqQ9h-Fd_oGB8Dem8UJOC5OOdajgyI",
     *    "avatar_url": "",
     *    "role": 0,
     *    "tel": "",
     *    "rating": 5,
     *    "review_count": 1,
     *    "created_at": "2019-01-04 03:39:43",
     *    "updated_at": "2019-01-10 04:26:50",
     *    "paypal_email": "sao_vu@paypal.com"
     * }
     *
     */
    public function updatePaypalEmail(UpdatePaypalEmailRequest $request)
    {
        $paypalEmail = $request->paypal_email;

        $responseData = $this->userService->updatePaypalEmail($paypalEmail);
        return response()->json($responseData, 202);
    }

    /**
     * PUT - Update User Data
     *
     *
     * @param UpdatePaypalEmailRequest $request
     * @bodyParam name string name of user
     * @bodyParam description string updating description
     * @bodyParam avatar_url string
     * @bodyParam avatar_name string
     * @bodyParam avatar_url string avatar url of user
     * @bodyParam tel string tel number
     *
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @response {
     *    "id": 1,
     *    "name": "RMT Admin",
     *    "email": "rmt.hblab@gmail.com",
     *    "description": "0.48",
     *    "avatar_bucket": "",
     *    "avatar_name": "EH0TvUkQA4xt1-O3Bm6kkssFityw3LTZsXr3cqxSOq4GkUaaJbuqQ9h-Fd_oGB8Dem8UJOC5OOdajgyI",
     *    "avatar_url": "",
     *    "role": 0,
     *    "tel": "",
     *    "rating": 5,
     *    "review_count": 1,
     *    "created_at": "2019-01-04 03:39:43",
     *    "updated_at": "2019-01-10 04:26:50",
     *    "paypal_email": "sao_vu@paypal.com"
     * }
     */
    public function update(Request $request)
    {
        $userData = $request->only([
            'name',
            'description',
            'avatar_url',
            'avatar_name',
            'avatar_url',
            'tel',
            'paypal_email',
        ]);
        foreach ($userData as $key => $value) {
            if (is_null($value)) {
                $userData[$key] = "";
            }
        }
        $responseData = $this->userService->update($userData);
        return response()->json($responseData, 202);
    }

    /**
     * PUT - Change User Password
     *
     * @bodyParam old_password string current password
     * @bodyParam new_password string updating password
     *
     * @param UpdatePaypalEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @response {
     * }
     */
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => 'required|string|max:127',
            'new_password' => 'required|string|min:6|max:127',
        ]);

        $this->userService->changePassword(
            $validatedData['old_password'],
            $validatedData['new_password']
        );

        return response()->json(null, 204);
    }

    /**
     * GET - User Public Products
     *
     *
     * @param Request $request
     * @queryParam count number product per page
     * @queryParam page paging
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     * "data": [
     *  {
     *      "id": "5c53af250724d",
     *      "title": "22",
     *      "game_id": 1,
     *      "description": "11",
     *      "delivery_method": 0,
     *      "buy_now_price": "12.00",
     *      "expired_date": "2019-02-02 02:29:57",
     *      "expiration": 1,
     *      "status": 1,
     *      "published_date": "2019-02-01 02:29:57",
     *      "user_id": 1,
     *      "view_count": 0,
     *       "created_at": "2019-02-01 02:29:57",
     *       "updated_at": "2019-02-01 02:32:41"
     *   }
     * ]
     * }
     */
    public function showPublicProducts(Request $request)
    {
        $userId = $request->id;
        $perPage = $request->query('count') ?? 10;
        $publicProducts = $this->userService->publicProducts($userId, $perPage);

        return response()->json($publicProducts, 200);
    }
}
