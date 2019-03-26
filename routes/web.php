<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin',
    'middleware' => ['admin', 'locale']
], function () {
    Auth::routes(['register' => false]);

    Route::get('change-language/{language}', 'Locale\ChangeLanguageController@changeLanguage')
        ->name('admin.change-language');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', 'DashboardController@show')->name('admin.dashboard');
        Route::get('/products', 'Product\ListController@index')->name('admin.product.list');
        Route::get('/products/{id}', 'Product\ShowController@show')->name('admin.product.detail');
        Route::get('/products/{id}/edit', 'Product\EditController@edit')->name('admin.product.edit');
        Route::post('/products/{id}', 'Product\UpdateController@update')->name('admin.product.update');
        Route::delete('/products/{id}', 'Product\StopController@main')->name('admin.product.stop');
        Route::post('/products/{id}/payment_success', 'Product\PaymentController@success')
            ->name('admin.product.payment_success');
        Route::post('/products/{id}/payment_cancel', 'Product\PaymentController@cancel')
            ->name('admin.product.payment_cancel');

        Route::post('/users/change_password', 'User\ChangePasswordController@main')->name('admin.user.change_password');
        Route::get('/users', 'User\ListController@index')->name('admin.user.list');
        Route::get('/users/{id}', 'User\ShowController@show')->name('admin.user.detail');
        Route::post('/users/{id}', 'User\UpdateController@update')->name('admin.user.update');

        Route::get('/setting', 'System\SettingController@show')->name('admin.system.setting');
        Route::post('/system/maintenance', 'System\MaintenanceController@store')->name('admin.system.maintenance');
        Route::post('/system/schedule', 'System\ScheduleController@store')->name('admin.system.schedule');
        Route::delete('/system/schedule/{id}', 'System\DestroyScheduleController@destroy')
            ->name('admin.system.delete_schedule');
        Route::post('/setting/fee', 'System\FeeController@edit')->name('admin.system.fee');

        Route::get('/ticket', 'Ticket\ListController@index')->name('admin.ticket.list');
        Route::get('/ticket/{id}', 'Ticket\ShowController@show')->name('admin.ticket.show');
        Route::delete('/ticket/{id}', 'Ticket\CloseController@close')->name('admin.ticket.close');
        Route::get('/ticket_comment/{id}/', 'Ticket\ListCommentController@index')->name('admin.ticket.comment');
        Route::post('/ticket_comment/{id}/', 'Ticket\CommentController@store')->name('admin.ticket.comment.store');

        Route::group([
            'namespace' => 'TicketQuestion',
            'prefix' => 'ticket_question'
        ], function () {
            Route::get('/', 'ListController@index')->name('admin.ticket_question.list');
            Route::get('/create', 'CreateController@create')->name('admin.ticket_question.create');
            Route::post('/', 'StoreController@store')->name('admin.ticket_question.store');
            Route::get('/{id}/edit', 'EditController@edit')->name('admin.ticket_question.edit');
            Route::put('/{id}', 'UpdateController@update')->name('admin.ticket_question.update');
        });

        Route::group([
            'namespace' => 'Category',
            'prefix' => 'category'
        ], function () {
            Route::get('/', 'ListController@index')->name('admin.category.list');
            Route::get('/create', 'CreateController@create')->name('admin.category.create');
            Route::post('/', 'StoreController@store')->name('admin.category.store');
            Route::get('/{id}/edit', 'EditController@edit')->name('admin.category.edit');
            Route::put('/{id}', 'UpdateController@update')->name('admin.category.update');
        });

        Route::group([
            'namespace' => 'Game',
            'prefix' => 'game'
        ], function () {
            Route::get('/', 'ListController@index')->name('admin.game.list');
            Route::get('/create', 'CreateController@create')->name('admin.game.create');
            Route::post('/', 'StoreController@store')->name('admin.game.store');
            Route::get('/{id}/edit', 'EditController@edit')->name('admin.game.edit');
            Route::put('/{id}', 'UpdateController@update')->name('admin.game.update');
        });

        Route::group([
            'namespace' => 'Notification',
            'prefix' => 'notification'
        ], function () {
            Route::get('/', 'IndexController@index')->name('admin.notification.index');
            Route::post('readall', 'ReadAllController@main')->name('admin.notification.readall');
        });

        Route::group([
            'namespace' => 'RequestBuying',
            'prefix' => 'request-buying'
        ], function () {
            Route::get('/', 'IndexController@index')->name('admin.request_buying.index');
            Route::get('/{id}', 'ShowController@show')->name('admin.request_buying.show');
            Route::put('/{id}', 'CloseController@close')->name('admin.request_buying.close');
        });

        Route::group([
            'namespace' => 'Profile',
            'prefix' => 'profile'
        ], function () {
            Route::get('/', 'EditController@edit')->name('admin.profile.edit');
            Route::put('/', 'UpdateController@update')->name('admin.profile.update');
        });
    });
});
