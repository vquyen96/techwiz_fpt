<?php

namespace App\Services;

use App\Repositories\NotificationAdminRepository;
use App\Repositories\TicketRepository;
use App\Repositories\TicketQuestionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Enums\Tickets\Status as TicketStatus;
use App\Enums\Notifications\Status as NotiStatus;
use App\Enums\User\Role;
use App\Helpers\ProductHelper;
use App\Enums\NotificationAdmin\Type as NotiAdminType;

class TicketService implements TicketServiceInterface
{
    private $ticketRepository;
    private $ticketQuestionRepository;
    private $productHelper;
    private $notiAdminRepository;
    private $mailService;

    public function __construct(
        TicketRepository $ticketRepository,
        TicketQuestionRepository $ticketQuestionRepository,
        ProductHelper $productHelper,
        NotificationAdminRepository $notiAdminRepository,
        MailServiceInterface $mailService
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->ticketQuestionRepository = $ticketQuestionRepository;
        $this->productHelper = $productHelper;
        $this->notiAdminRepository = $notiAdminRepository;
        $this->mailService = $mailService;
    }

    public function create($ticketData, $imagesData)
    {
        $userAuth = Auth::user();
        $ticket = array_merge($ticketData, [
            'user_id' => $userAuth->id,
            'status' => TicketStatus::CREATED,
            'id' => uniqid(),
        ]);
        $imagesInDB = $this->productHelper->checkImagesInDB($imagesData);

        $notiAdminData = [
            'target_id' => $userAuth->id,
            'type' => NotiAdminType::TICKET,
            'image_url' => $userAuth->avatar_url,
            'status' => NotiStatus::CREATE
        ];
        return DB::transaction(function () use ($ticket, $imagesInDB, $notiAdminData, $userAuth) {
            $createdTicket = $this->ticketRepository->create(
                $ticket
            );
            $notiAdminData = array_merge($notiAdminData, [
                'path' => 'ticket/'.$createdTicket->id
            ]);
            $this->notiAdminRepository->create($notiAdminData);
            $createdTicket->images()->attach($imagesInDB);

            $this->mailService->sendReceivedTicket($userAuth);

            return $createdTicket;
        });
    }

    public function solveTicket($ticketId)
    {
        $ticket = $this->ticketRepository->find($ticketId);
        $this->validatePermission($ticket);
        if ($ticket->status !== TicketStatus::CREATED
            && $ticket->status !== TicketStatus::IN_PROGRESS) {
            abort(409);
        }
        return $this->ticketRepository->update([
            'status' => TicketStatus::SOLVED,
        ], $ticketId);
    }

    public function updateTicket($ticketId, $data)
    {
        if (Auth::user()->role !== Role::ADMIN) {
            abort(403);
        }
        return $this->ticketRepository->update($data, $ticketId);
    }


    public function comment($commentData, $imagesData)
    {
        $authUser = Auth::user();
        $ticketDetail = $this->ticketRepository
                        ->find($commentData['ticket_id']);
        if ($ticketDetail->status > TicketStatus::IN_PROGRESS) {
            return session()->flash('error', 'Maintenance mode disabled successfully!');
        }
        $this->validatePermission($ticketDetail);
        
        $comment = array_merge($commentData, ['user_id' => $authUser->id,]);
        $notiData = [];
        $notiAdminData = [];
        if ($authUser->role == Role::ADMIN) {
            $notiData = [
                'title' => 'New message',
                'content' => 'Admin has reply your ticket',
                'type' => NotiType::SYSTEM,
                'image_url' => $authUser->avatar_url,
                'path' => 'ticket?id='.$ticketDetail->id,
                'status' => NotiStatus::CREATE,
                'user_id' => $ticketDetail->user_id,
            ];
        } else {
            $notiAdminData = [
                'target_id' => $authUser->id,
                'type' => NotiAdminType::TICKET_COMMENT,
                'image_url' => $authUser->avatar_url,
                'path' => 'ticket_comment/'.$ticketDetail->id,
                'status' => NotiStatus::CREATE
            ];
        }

        $imagesInDB = $this->productHelper->checkImagesInDB($imagesData);
        return DB::transaction(function () use (
            $comment,
            $imagesInDB,
            $notiData,
            $notiAdminData,
            $authUser,
            $ticketDetail
        ) {
            $createdComment = $this->ticketCommentRepository->create(
                $comment
            );
            $createdComment->images()->attach($imagesInDB);

            if ($authUser->role == Role::ADMIN) {
                $this->notiRepository->create($notiData);
            } else {
                $this->notiAdminRepository->create($notiAdminData);
            }

            if ($ticketDetail->status != TicketStatus::IN_PROGRESS) {
                $ticketDetail->update(['status' => TicketStatus::IN_PROGRESS]);
            }
            return $createdComment;
        });
    }

    public function myTicket($perPage, $ticketStatus)
    {
        $tickets = $this->ticketRepository->myTicket($perPage, $ticketStatus);
        return [
            'total' => $tickets->total(),
            'tickets' => $tickets->all(),
        ];
    }

    public function showTicketDetail($id)
    {
        $ticketDetail = $this->ticketRepository
            ->with([
                'comments',
                'comments.images',
                'comments.user:name,avatar_url,id',
                'images',
                'user:name,avatar_url,id'
            ])
            ->find($id);
        $this->validatePermission($ticketDetail);
        return [
            'ticket' => $ticketDetail,
        ];
    }

    public function allQuestion()
    {
        $allQuestion = $this->ticketQuestionRepository->allQuestion();
        $groupQuestion = [];
        foreach ($allQuestion as $question) {
            if (!isset($groupQuestion[$question['lang']])) {
                $groupQuestion[$question['lang']] = [];
            }
            array_push(
                $groupQuestion[$question['lang']],
                (object) [
                    'id' => $question['id'],
                    'title' => $question['title'],
                    'description' => $question['description'],
                    'lang' => $question['lang'],
                    'slug' => $question['slug'],
                    'parent_id' => $question['parent_id'],
                ]
            );
        }
        return [
            'questions' => $groupQuestion,
        ];
    }

    private function validatePermission($ticketDetail)
    {
        $authUser = Auth::user();
        if (!isset($ticketDetail)) {
            abort(404);
        }
        if ($authUser->role !== Role::ADMIN && $ticketDetail->user_id !== $authUser->id) {
            abort(403);
        }
    }

    public function close($id)
    {
        $ticket = $this->ticketRepository->find($id);
        return $ticket->update(['status' => TicketStatus::CLOSED]);
    }
}
