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

Route::group(['prefix' => 'admin', 'as' => 'admin.api.' , 'namespace' => 'Api'], function () {
    Route::put('posts/{id}/status', 'PostController@changeStatus')->name('posts.update.status');
    Route::apiResource('images', 'ImageController')->parameters(['images' => 'id']);
    Route::put('orders/{id}/status', 'OrderController@changeStatus')->name('orders.update.status');
    Route::apiResource('comments', 'CommentController')->parameters(['comments' => 'id']);
});
