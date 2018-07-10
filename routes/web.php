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
Route::group(['namespace' => 'Home'], function () {
    Route::resource('products', 'ProductController');
    Route::get('/', 'HomeController@index')->name('user.home');
    Route::get('login', 'LoginController@showLoginForm')->name('user.login');
    Route::get('/register', 'RegisterController@index')->name('user.register');
    Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::get('profile', 'UserController@index')->name('user.info');
    Route::get('/locale/{locale}', function ($locale) {
        session(['locale' => $locale]);

        return response()->json(['locale' => session('locale')], 200);
    })->name('locale');
});

//Api Doc
Route::get('/api-docs', function () {
    return view('api-docs');
});
Route::get('/api-doc-builders', function () {
    return view('api-doc-builders.index');
});

// Todo: add middleware for admin authenticate
Route::group(['prefix' => 'admin', 'as' => 'admin.' , 'namespace' => 'Admin', 'middleware' => ['auth:web', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('homepage');
    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController')->parameters(['products' => 'id']);
    Route::resource('posts', 'PostController')->parameters(['posts' => 'id']);
    Route::post('avatar/{id}', 'UserController@updateAvt')->name('avatar.update');
    Route::resource('users', 'UserController');
    Route::resource('orders', 'OrderController')->parameters(['orders' => 'id']);

});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->middleware(['auth:web', 'admin'])->name('logout');
});
Route::get('home', 'HomeController@index')->name('home');
