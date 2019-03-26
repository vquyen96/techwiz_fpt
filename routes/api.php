<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'API',
    'prefix' => 'v1',
], function () {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('signin', 'AuthController@signin');
        Route::post('register', 'AuthController@register');
        Route::post('register_company', 'AuthController@registerCompany');
        Route::post('forgotPassword', 'AuthController@forgotPassword');
        Route::post('send_mail_verify', 'AuthController@sendMailVerify');
    });
    
    Route::get('/user/verify/{token}', 'AuthController@verifyUser');
    Route::post('/user/reset_password/{token}', 'AuthController@reset');

    Route::group([
        'middleware' => 'auth.jwt',
        'prefix' => 'auth',
    ], function () {
        Route::get('me', 'AuthController@me');
        Route::post('signout', 'AuthController@signOut');
    });

    Route::get('categories', 'CategoryController@index');
    Route::get('locations', 'LocationController@index');
});
