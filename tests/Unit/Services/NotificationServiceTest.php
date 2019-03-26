<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\NotificationService;
use App\Models\Notification;
use App\Helpers\NotificationHelper;
use App\Repositories\NotificationRepository;

class NotificationServiceTest extends TestCase
{
    /**
     * Test get notification
     *
     * @return void
     */
    public function testGetNotificationShouldSuccess()
    {
        $sampleCountUnread = 3;
        $sampleNotification = [
            [
                'id' => 1,
                'title' => 'You have won a bid',
                'content' => 'Macbook pro 256G',
                'type' => 1,
                'image_url' => 'https://hblab-rmt-test.s3.ap-northeast-1.amazonaws.com/picture-5bfdf46b15d42.jpeg',
                'path' => 'product/5bf3eadba3368',
                'status' => 0,
                'created_at' => '2018-11-27 03:33:35'
            ],
            [
                'id' => 2,
                'title' => 'You have won a bid',
                'content' => 'Macbook pro 256G',
                'type' => 1,
                'image_url' => 'https://hblab-rmt-test.s3.ap-northeast-1.amazonaws.com/picture-5bfdf46b15d42.jpeg',
                'path' => 'product/5bf3eadba3368',
                'status' => 0,
                'created_at' => '2018-11-27 03:33:35'
            ],
            [
                'id' => 3,
                'title' => 'You have won a bid',
                'content' => 'Macbook pro 256G',
                'type' => 1,
                'image_url' => 'https://hblab-rmt-test.s3.ap-northeast-1.amazonaws.com/picture-5bfdf46b15d42.jpeg',
                'path' => 'product/5bf3eadba3368',
                'status' => 0,
                'created_at' => '2018-11-27 03:33:35'
            ]
        ];

        $selectedFields = [
            'id',
            'title',
            'content',
            'type',
            'image_url',
            'path',
            'status',
            'created_at'
        ];
        \Auth::shouldReceive('id')->andReturn(1);
        $notificationRepository = \Mockery::mock(NotificationRepository::class);
        $notificationHelper = \Mockery::mock(NotificationHelper::class);
        $notificationRepository->shouldReceive('getNotification')
                            ->with(1, [0, 1, 2], 10, $selectedFields)
                            ->andReturn(collect($sampleNotification))
                            ->shouldReceive('all')
                            ->andReturn($sampleNotification);
        $notificationRepository->shouldReceive('getCountUnread')
                            ->andReturn($sampleCountUnread);
        $notificationService = new NotificationService($notificationHelper, $notificationRepository);
        $response = $notificationService->getNotification(0, 10);

        $this->assertEquals($response['count_unread'], $sampleCountUnread);
        $this->assertEquals($response['notifications'], $sampleNotification);
    }

    /**
     * Test read notification
     *
     * @return void
     */
    public function testReadNotificationShouldSuccess()
    {
        $sampleStatus = 1;
        $notificationRepository = \Mockery::mock(NotificationRepository::class);
        $notificationHelper = \Mockery::mock(NotificationHelper::class);
        $notificationRepository->shouldReceive('update')->andReturn($sampleStatus);
        $notificationService = new NotificationService($notificationHelper, $notificationRepository);
        $response = $notificationService->readNotification(1);
        $this->assertEquals($response['status'], $sampleStatus);
    }
}
