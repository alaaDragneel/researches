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

Route::middleware('auth:api')->group(function () {
    Route::patch('/posts/{post}/archive', 'PostsController@archive');
    Route::delete('/posts/{post}/archive', 'PostsController@unArchive');
});

Route::prefix('auth')->namespace('Api')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('register/activate/{token}', 'AuthController@registerActivate');
  
    Route::middleware('auth:api')->group(function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
