<?php

namespace App\Http\Controllers\API;

use App\Services\PrivateMessageServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * @group Conversation
 */
class PrivateMessageController extends Controller
{
    private $privateMessageService;

    public function __construct(PrivateMessageServiceInterface $privateMessageService)
    {
        $this->privateMessageService = $privateMessageService;
    }

    /**
     * List Private Messages of Conversation
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @queryParam count integer required count element of page
     * @queryParam page integer required number of page
     *
     * @response {
     *   "conversation": {
     *       "id": "5c877431f07bb",
     *       "title": "Helllo1",
     *       "description": "12323",
     *       "status": 0,
     *       "from_user_id": "5c87354005405",
     *       "to_user_id": "5c873540fe405",
     *       "created_at": "2019-03-12 08:56:17",
     *       "updated_at": "2019-03-12 09:03:15"
     *    },
     *   "messages": [
     *      {
     *          "id": "5c88bb33722cd",
     *          "conversation_id": "5c877431f07bb",
     *          "user_id": "5c87354005405",
     *          "content": "Hihi",
     *          "created_at": "2019-03-13 08:11:31",
     *          "updated_at": "2019-03-13 08:11:31",
     *          "user": {
     *              "id": "5c87354005405",
     *              "name": "Quyến",
     *              "email": "vquyenaaa@gmail.com",
     *              "description": "",
     *              "avatar_url": ""
     *          },
     *          "images": [
     *              {
     *                  "id": 1,
     *                  "thumbnail_bucket": "i.ibb.co/",
     *                  "thumbnail_name": "logo-square.jpg",
     *                  "thumbnail_url": "https://i.ibb.co/VWpMQ9h/logo-square.jpg",
     *                  "picture_bucket": "i.ibb.co/",
     *                  "picture_url": "https://i.ibb.co/VWpMQ9h/logo-square.jpg",
     *                  "picture_name": "logo-square.jpg",
     *                  "title": "LUC888",
     *                  "created_at": "2019-03-11 09:53:12",
     *                  "updated_at": "2019-03-11 09:53:12"
     *              }
     *          ]
     *      }
     *  ],
     *  "total": 7
     *  }
     */
    public function index(Request $request, $id)
    {
        $perPage = $request->query('count') ?? 10;
        $page = $request->query('page') ?? 1;

        return response()->json($this->privateMessageService->list($id, $perPage, $page), 201);
    }

    /**
     * Reply Private Messages
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam message string required Messages of Private Messages
     * @bodyParam images string required Image of message
     *
     * @response {
     *      "message": "OK"
     * }
     */
    public function reply(Request $request, $id)
    {

        $validatedData = $request->validate([
            'message' => 'required|string|max:1000',
            'images' => [
                'present',
                'nullable',
                'string',
                'regex:/[0-9\|]*$/',
            ],
        ]);

        $dataMes = $this->getDataMess($validatedData, $id);
        $imagesData = $request->input('images');
        $this->privateMessageService->send(
            $id,
            $dataMes,
            $imagesData
        );
        return response()->json([ "message" => "OK"], 201);
    }

    private function getDataMess($data, $id)
    {
        return [
            'id' => uniqid(),
            'conversation_id' => $id,
            'user_id' => Auth::id(),
            'content' => $data['message']
        ];
    }
}
