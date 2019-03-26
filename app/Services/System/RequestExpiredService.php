<?php
namespace App\Services\System;

use App\Repositories\RequestRepository;
use App\Services\MailServiceInterface;
use App\Enums\Request\Status as RequestStatus;

use App\Services\NotificationServiceInterface;

class RequestExpiredService implements RequestExpiredServiceInterface
{
    private $requestRepository;
    private $mailService;
    private $notificationService;

    public function __construct(
        RequestRepository $requestRepository,
        MailServiceInterface $mailService,
        NotificationServiceInterface $notificationService
    ) {
        $this->requestRepository = $requestRepository;
        $this->mailService = $mailService;
        $this->notificationService = $notificationService;
    }

    public function expiredRequest()
    {
        $requests = $this->requestRepository->getExpired();
        foreach ($requests as $request) {
            $this->updateRequestExpired($request);
            $this->mailService->sendExpiredRequest($request);
            $this->notificationService->sendRequestExpiredNotification($request);
        }
    }

    private function updateRequestExpired($request)
    {
        $this->requestRepository->update([
            'status' => RequestStatus::CLOSED
        ], $request->id);
    }
}
