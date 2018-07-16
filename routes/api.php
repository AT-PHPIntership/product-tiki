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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'admin', 'as' => 'admin.api.' , 'namespace' => 'Api\Admin'], function () {
    Route::put('posts/{id}/status', 'PostController@changeStatus')->name('posts.update.status');
    Route::apiResource('images', 'ImageController')->parameters(['images' => 'id']);
    Route::put('orders/{order}/status', 'OrderController@changeStatus')->name('orders.update.status');
    Route::apiResource('comments', 'CommentController')->parameters(['comments' => 'id']);
    Route::get('/', 'HomeController@index')->name('home');
});

Route::group(['as' => 'api.', 'namespace' => 'Api\User'], function () {
    Route::apiResource('products', 'ProductController');
    Route::apiResource('posts/{post}/comments', 'CommentController');
    Route::apiResource('posts', 'PostController')->middleware('auth:api');
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('orders', 'OrderController')->middleware('auth:api');
    Route::get('products/{product}/posts', 'ProductController@getPosts');
    Route::post('products/{product}/posts', 'PostController@store')->middleware('auth:api');
    Route::get('products/{productBase}/compare/{productCompare}', 'ProductController@compare');
    Route::post('login', 'LoginController@login');
    Route::post('register', 'LoginController@register');
    Route::post('/password/reset', 'ForgotPasswordController@sendResetLinkEmail');
    Route::put('/password/reset', 'ResetPasswordController@reset');
    Route::post('/login-facebook', 'LoginController@facebook');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('posts/{post}/comments', 'CommentController@store');
        Route::put('comments/{comments}', 'CommentController@update');
        Route::delete('comments/{comments}', 'CommentController@delete');
        Route::post('details', 'LoginController@details');
        Route::post('logout', 'LoginController@logout');
        Route::get('checkAccessToken', 'LoginController@checkAccessToken');
        Route::get('users/profile', 'UserController@index');
        Route::put('users/profile', 'UserInfoController@update');
        Route::put('users/orders/{order}/cancel', 'OrderController@cancel');
        Route::get('users/profile/address', 'UserInfoController@listAddress');
        Route::put('users/profile/address/{address}', 'UserInfoController@updateAddress');
    });

});
