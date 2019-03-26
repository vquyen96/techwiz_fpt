<?php
namespace App\Services;

use App\Enums\User\Role;
use App\Helpers\Notifications\Ticket\CommentHelper;
use App\Helpers\ProductHelper;
use App\Repositories\NotificationAdminRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\TicketCommentRepository;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;
use App\Enums\Tickets\Status as TicketStatus;
use Illuminate\Support\Facades\DB;

class TicketCommentService implements TicketCommentServiceInterface
{
    private $ticketRepository;
    private $commentHelper;
    private $productHelper;
    private $notiRepository;
    private $notiAdminRepository;
    private $ticketCommentRepository;
    private $mailService;

    public function __construct(
        TicketRepository $ticketRepository,
        CommentHelper $commentHelper,
        ProductHelper $productHelper,
        NotificationRepository $notiRepository,
        NotificationAdminRepository $notiAdminRepository,
        TicketCommentRepository $ticketCommentRepository,
        \App\Services\Admin\MailServiceInterface $mailService
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->commentHelper = $commentHelper;
        $this->productHelper = $productHelper;
        $this->notiRepository = $notiRepository;
        $this->notiAdminRepository = $notiAdminRepository;
        $this->ticketCommentRepository = $ticketCommentRepository;
        $this->mailService = $mailService;
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
        $mailData = null;
        if ($authUser->role == Role::ADMIN) {
            $notiData = $this->commentHelper->buildDataNotificationUser($authUser, $ticketDetail);
            $mailData = $this->commentHelper->buildDataMailUser($ticketDetail);
        } else {
            $notiAdminData = $this->commentHelper->buildDataNotificationAdmin($authUser, $ticketDetail);
        }

        $imagesInDB = $this->productHelper->checkImagesInDB($imagesData);
        return DB::transaction(function () use (
            $comment,
            $imagesInDB,
            $notiData,
            $notiAdminData,
            $authUser,
            $ticketDetail,
            $mailData
        ) {
            $createdComment = $this->ticketCommentRepository->create(
                $comment
            );
            $createdComment->images()->attach($imagesInDB);

            if ($authUser->role == Role::ADMIN) {
                $this->notiRepository->create($notiData);
                $this->mailService->sendTicketComment($mailData);
            } else {
                $this->notiAdminRepository->create($notiAdminData);
            }

            if ($ticketDetail->status != TicketStatus::IN_PROGRESS) {
                $ticketDetail->update(['status' => TicketStatus::IN_PROGRESS]);
            }
            return $createdComment;
        });
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
}
