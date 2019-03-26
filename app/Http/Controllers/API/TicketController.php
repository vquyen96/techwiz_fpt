<?php

namespace App\Http\Controllers\API;

use App\Services\TicketCommentServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TicketServiceInterface;
use Validator;

/**
 * @group Ticket
 */
class TicketController extends Controller
{
    
    private $ticketService;
    private $ticketCommentService;

    public function __construct(
        TicketServiceInterface $ticketService,
        TicketCommentServiceInterface $ticketCommentService
    ) {
        $this->ticketService = $ticketService;
        $this->ticketCommentService = $ticketCommentService;
    }

    /**
     * Create Ticket
     * Create a new Ticket to Admin
     *
     * @bodyParam title required string title of ticket
     * @bodyParam content required string content of what you wanna report
     * @bodyParam images required string list image id 1|2|3
     * @bodyParam product_url required string link to product
     * @bodyParam ticket_question_id required integer id of question
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * }
     */
    public function create(Request $request)
    {
        $ticketData = $request->validate([
            'ticket_question_id' => 'required|exists:ticket_questions,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:65535',
            'images' => [
                'present',
                'nullable',
                'string',
                'regex:/[0-9\|]*$/',
            ],
            'product_url' => [
                'nullable',
                'url'
            ]
        ]);
        $imagesData = $request->input('images');

        $responseData = $this->ticketService->create($ticketData, $imagesData);
        return response()->json($responseData, 201);
    }

    /**
     * Mark Ticket Solved
     * Change Status of Ticket to solved
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * }
     */
    public function solve(Request $request)
    {
        $ticketId = $request->route('id');

        $this->ticketService->solveTicket($ticketId);
        return response()->json(null, 200);
    }

    /**
     * Update Ticket
     * Update data of Ticket
     *
     * @bodyParam title string title of ticket
     * @bodyParam content string content of what you wanna report
     * @bodyParam status integer status of ticket
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * }
     */
    public function update(Request $request)
    {
        $ticketData = $request->only([
            'title',
            'content',
            'status',
        ]);
        
        $ticketId = $request->route('id');

        $responseData = $this->ticketService
                            ->updateTicket($ticketId, $ticketData);
        return response()->json($responseData, 200);
    }

    /**
     * Comment on Ticket
     * Add comment on Ticket
     *
     * @queryParam content string content of what you wanna report
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * "content": "I do not know",
     * "ticket_id": "5c4fd83f90b62",
     * "user_id": 2,
     * "updated_at": "2019-01-29 04:38:22",
     * "created_at": "2019-01-29 04:38:22",
     * "id": 3
     *}
     */
    public function comment(Request $request)
    {
        $ticketData = $request->validate([
            'content' => 'required|string|max:65535',
            'images' => [
                'present',
                'nullable',
                'string',
                'regex:/[0-9\|]*$/',
            ],
        ]);
        $commentData = array_merge($ticketData, [
            'ticket_id' => $request->route('id'),
        ]);
        $imagesData = $request->input('images');
        $responseData = $this->ticketCommentService
                            ->comment($commentData, $imagesData);
        return response()->json($responseData, 201);
    }

    /**
     * My Tickets
     * Get All of my tickets
     * @queryParam ticket_status string filter by status: [pending, solved, close]
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     * "total": 1,
     *  "tickets": [
     *  {
     *      "id": "5c4fd83f90b62",
     *      "title": "Pazankata kata nana",
     *      "content": "Ako nano bobo?",
     *      "status": 0,
     *      "user_id": 2,
     *      "product_url": "https://rmt2.test.hblab.co.jp/product/5c4988e16318b",
     *      "created_at": "2019-01-29 04:36:15",
     *      "updated_at": "2019-01-29 04:36:15"
     *  }
     * ]
     * }
     */
    public function myTicket(Request $request)
    {
        $perPage = $request->query('count') ?? 10;
        $ticketStatus = $request->query('ticket_status');
        $responseData = $this->ticketService->myTicket($perPage, $ticketStatus);
        return response()->json($responseData, 200);
    }

    /**
     * Ticket Detail
     * Show ticket detail
     *
     * @queryParam content string content of what you wanna report
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     *   "ticket": {
     *   "id": "5c4ea7b1954c3",
     *   "title": "Need help",
     *   "content": "WTH with you?",
     *   "status": 2,
     *   "user_id": 2,
     *   "created_at": "2019-01-28 06:56:49",
     *   "updated_at": "2019-01-28 07:41:25",
     *   "comments": [
     *       {
     *           "id": 1,
     *           "content": "I was scammed",
     *           "user_id": 2,
     *           "ticket_id": "5c4ea7b1954c3",
     *           "created_at": "2019-01-28 07:47:28",
     *           "updated_at": "2019-01-28 07:47:28"
     *       }
     *     ]
     *   }
     *   }
     */
    public function show($id)
    {
        $responseData = $this->ticketService->showTicketDetail($id);
        return response()->json($responseData, 200);
    }

    /**
     * All Question
     * Get All question with localized text
     *
     * @queryParam content string content of what you wanna report
     * @return \Illuminate\Http\JsonResponse
     *
     * @response
     * {
     *   "question": [
     *   {
     *      "id": 1,
     *      "description": "register problem",
     *      "title": "About member registration / login",
     *      "lang": "en"
     *  },
     *  {
     *      "id": 1,
     *      "description": "register problem",
     *      "title": "会員登録・ログインについて",
     *      "lang": "ja"
     *  }
     *  ]
     * }
     */
    public function allQuestion()
    {
        $responseData = $this->ticketService->allQuestion();
        return response()->json($responseData, 200);
    }
}
