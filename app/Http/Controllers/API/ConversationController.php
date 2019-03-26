<?php

namespace App\Http\Controllers\API;

use App\Services\ConversationServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\Conversation\Status;

/**
 * @group Conversation
 */
class ConversationController extends Controller
{
    private $conversationService;

    public function __construct(ConversationServiceInterface $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    /**
     * List Conversation from User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @queryParam perPage integer required count element of page
     * @queryParam page integer required number of page
     *
     * @response {
     *   "data": [
     *      {
     *          "id": "5c8768ddc8a93",
     *          "title": "Helllo1",
     *          "status": 1,
     *          "from_user_id": "5c87354005405",
     *          "name": "RMT User",
     *          "avatar_url": "",
     *          "created_at": "2019-03-12 08:07:57",
     *          "last_private_messages": {
     *              "id": "5c88bb33722cd",
     *              "conversation_id": "5c877431f07bb",
     *              "user_id": "5c87354005405",
     *              "content": "Hihi",
     *              "created_at": "2019-03-13 08:11:31",
     *              "updated_at": "2019-03-13 08:11:31"
     *         }
     *      }
     *      ],
     *      "total": 3
     *  }
     */
    public function indexFromUser(Request $request)
    {
        $perPage = $request->query('perPage') ?? 10;
        $page = $request->query('page') ?? 10;
        $responseData = $this->conversationService->indexFromUser($perPage, $page);
        return response()->json($responseData, 200);
    }

    /**
     * List Conversation to User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @queryParam perPage integer required count element of page
     * @queryParam page integer required number of page
     *
     * @response {
     *   "data": [
     *      {
     *          "id": "5c8768ddc8a93",
     *          "title": "Helllo1",
     *          "status": 1,
     *          "from_user_id": "5c87354005405",
     *          "name": "RMT User",
     *          "avatar_url": "",
     *          "created_at": "2019-03-12 08:07:57",
     *          "last_private_messages": {
     *              "id": "5c88bb33722cd",
     *              "conversation_id": "5c877431f07bb",
     *              "user_id": "5c87354005405",
     *              "content": "Hihi",
     *              "created_at": "2019-03-13 08:11:31",
     *              "updated_at": "2019-03-13 08:11:31"
     *         }
     *      }
     *      ],
     *      "total": 4
     *  }
     */
    public function indexToUser(Request $request)
    {
        $perPage = $request->query('perPage') ?? 10;
        $page = $request->query('page') ?? 1;
        $responseData = $this->conversationService->indexToUser($perPage, $page);
        return response()->json($responseData, 200);
    }

    /**
     * Create Conversation and Private message
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam title string required Title of Conversation
     * @bodyParam description string required Description of Conversation and content of message
     * @bodyParam to_user_id string required Id of user to send
     * @bodyParam images string required Image of message
     *
     * @response {
     *      "message": "OK"
     * }
     */
    public function store(Request $request)
    {
        $imagesData = $request->input('images');
        $this->validationStore($request);
        $data = $this->getDataStore($request);
        $dataMess = $this->getDataMess($data);
        $this->conversationService->create($data, $dataMess, $imagesData);
        return response()->json('ok', 200);
    }

    private function validationStore($request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'to_user_id' => 'required|string|max:65535',
            'images' => [
                'present',
                'nullable',
                'string',
                'regex:/[0-9\|]*$/',
            ],
        ]);
    }

    private function getDataStore($request)
    {
        return [
            'title' => $request->title,
            'description' => $request->description,
            'to_user_id' => $request->to_user_id,
            'status' => Status::ACTIVE,
            'from_user_id' => Auth::id(),
            'id' => uniqid()
        ];
    }

    private function getDataMess($data)
    {
        return [
            'id' => uniqid(),
            'conversation_id' => $data['id'],
            'user_id' => $data['from_user_id'],
            'content' => $data['description']
        ];
    }

    /**
     * Close Conversation
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response {
     *      "message": "OK"
     * }
     */
    public function close($id)
    {
        $this->conversationService->close($id);
        return response()->json('ok', 200);
    }
}
