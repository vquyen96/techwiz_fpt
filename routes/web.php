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
    'middleware' => ['admin']
], function () {
    Auth::routes(['register' => false]);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', 'DashboardController@show')->name('admin.dashboard');

        Route::post('/users/change_password', 'User\ChangePasswordController@main')->name('admin.user.change_password');
        Route::get('/users', 'User\ListController@index')->name('admin.user.list');
        Route::get('/users/{id}', 'User\ShowController@show')->name('admin.user.detail');
        Route::post('/users/{id}', 'User\UpdateController@update')->name('admin.user.update');

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
            'namespace' => 'Profile',
            'prefix' => 'profile'
        ], function () {
            Route::get('/', 'EditController@edit')->name('admin.profile.edit');
            Route::put('/', 'UpdateController@update')->name('admin.profile.update');
        });
    });
});
