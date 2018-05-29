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

Route::get('/', function () {
    return view('welcome');
});

// Todo: add middleware for admin authenticate
Route::group(['prefix' => 'admin', 'as' => 'admin.' , 'namespace' => 'Admin', 'middleware' => ['auth:web', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('categories', 'CategoryController')->parameters(['categories' => 'id']);
    Route::resource('products', 'ProductController')->parameters(['products' => 'id']);
    Route::resource('posts', 'PostController')->parameters(['posts' => 'id']);
    Route::resource('users', 'UserController')->parameters(['users' => 'id']);
    Route::resource('orders', 'OrderController')->parameters(['orders' => 'id']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');