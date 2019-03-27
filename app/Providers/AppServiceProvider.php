<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('admin.components.product-status', 'productStatus');
        Blade::component('admin.components.product-table', 'productTable');
        Blade::component('admin.components.product-transaction-status', 'productTransactionStatus');
        Blade::component('admin.components.rate-star', 'rateStar');
        Blade::component('admin.components.ticket-status', 'ticketStatus');
        Blade::component('admin.components.notification-title', 'notificationTitle');
        Blade::component('admin.components.notification-content', 'notificationContent');
        Blade::component('admin.components.request-status', 'requestStatus');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\AuthServiceInterface', 'App\Services\AuthService');
        $this->app->bind('App\Services\CategoryServiceInterface', 'App\Services\CategoryService');
        $this->app->bind('App\Services\LocationServiceInterface', 'App\Services\LocationService');
        $this->app->bind('App\Services\JobServiceInterface', 'App\Services\JobService');
        $this->app->bind('App\Services\CvServiceInterface', 'App\Services\CvService');
        $this->app->bind('App\Services\ImageServiceInterface', 'App\Services\ImageService');
        $this->app->bind('App\Services\MailServiceInterface', 'App\Services\MailService');
        $this->app->bind('App\Services\Admin\UserServiceInterface', 'App\Services\Admin\UserService');
        $this->app->bind('App\Services\Admin\AuthServiceInterface', 'App\Services\Admin\AuthService');
        $this->app->bind('App\Services\Admin\MailServiceInterface', 'App\Services\Admin\MailService');
        $this->app->bind(
            'App\Services\System\CronJobServiceInterface',
            'App\Services\System\CronJobService'
        );
        $this->app->bind(
            'App\Services\System\RequestExpiredServiceInterface',
            'App\Services\System\RequestExpiredService'
        );
        $this->app->bind('App\Services\GameServiceInterface', 'App\Services\GameService');
        $this->app->bind('App\Services\ProductServiceInterface', 'App\Services\ProductService');
        $this->app->bind('App\Services\ImageServiceInterface', 'App\Services\ImageService');
        $this->app->bind('App\Services\ProductTransferServiceInterface', 'App\Services\ProductTransferService');
        $this->app->bind('App\Services\ProductConfirmServiceInterface', 'App\Services\ProductConfirmService');
        $this->app->bind('App\Services\NotificationServiceInterface', 'App\Services\NotificationService');
        $this->app->bind('App\Services\ReviewServiceInterface', 'App\Services\ReviewService');
        $this->app->bind('App\Services\UserServiceInterface', 'App\Services\UserService');
        $this->app->bind('App\Services\AlertServiceInterface', 'App\Services\AlertService');
        $this->app->bind('App\Services\SearchServiceInterface', 'App\Services\SearchService');
        $this->app->bind('App\Services\ChattingServiceInterface', 'App\Services\ChattingService');
        $this->app->bind('App\Services\TicketServiceInterface', 'App\Services\TicketService');
        $this->app->bind('App\Services\TicketCommentServiceInterface', 'App\Services\TicketCommentService');
        $this->app->bind('App\Services\ConversationServiceInterface', 'App\Services\ConversationService');
        $this->app->bind('App\Services\PaypalPaymentServiceInterface', 'App\Services\PaypalPaymentService');
        $this->app->bind('App\Services\RequestBuyingServiceInterface', 'App\Services\RequestBuyingService');
        $this->app->bind('App\Services\PrivateMessageServiceInterface', 'App\Services\PrivateMessageService');
        $this->app->bind('App\Services\Admin\ProductServiceInterface', 'App\Services\Admin\ProductService');
        $this->app->bind('App\Services\Admin\UserServiceInterface', 'App\Services\Admin\UserService');
        $this->app->bind('App\Services\Admin\SystemServiceInterface', 'App\Services\Admin\SystemService');
        $this->app->bind('App\Services\Admin\AuthServiceInterface', 'App\Services\Admin\AuthService');
        $this->app->bind('App\Services\Admin\MailServiceInterface', 'App\Services\Admin\MailService');
        $this->app->bind('App\Services\Admin\FeeServiceInterface', 'App\Services\Admin\FeeService');
        $this->app->bind('App\Services\Admin\TicketServiceInterface', 'App\Services\Admin\TicketService');
        $this->app->bind(
            'App\Services\Admin\TicketQuestionServiceInterface',
            'App\Services\Admin\TicketQuestionService'
        );
        $this->app->bind(
            'App\Services\Admin\TicketCommentServiceInterface',
            'App\Services\Admin\TicketCommentService'
        );
        $this->app->bind(
            'App\Services\Admin\ImageTicketCommentServiceInterface',
            'App\Services\Admin\ImageTicketCommentService'
        );
        $this->app->bind(
            'App\Services\Admin\CategoryServiceInterface',
            'App\Services\Admin\CategoryService'
        );
        $this->app->bind(
            'App\Services\Admin\NotificationAdminServiceInterface',
            'App\Services\Admin\NotificationAdminService'
        );
        $this->app->bind(
            'App\Services\Admin\GameServiceInterface',
            'App\Services\Admin\GameService'
        );
        $this->app->bind(
            'App\Services\Admin\RequestBuyingServiceInterface',
            'App\Services\Admin\RequestBuyingService'
        );
        $this->app->bind(
            'App\Services\Admin\ProfileServiceInterface',
            'App\Services\Admin\ProfileService'
        );
        $this->app->bind(
            'App\Services\System\CronJobServiceInterface',
            'App\Services\System\CronJobService'
        );
        $this->app->bind(
            'App\Services\System\RequestExpiredServiceInterface',
            'App\Services\System\RequestExpiredService'
        );
    }
}
