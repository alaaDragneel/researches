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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts/search', 'PostsController@search')->name('posts.search');

Route::get('/posts/carbon', 'PostsController@carbon');

Route::get('/posts/download/{type}', 'PostsController@download')->name('posts.download');


Route::get('/posts/import', 'PostsController@import')->name('posts.import');
Route::post('/posts/import/parse', 'PostsController@importParse')->name('posts.import.parse');
Route::post('/posts/import/process', 'PostsController@importProcess')->name('posts.import.process');

Route::resource('/posts', 'PostsController');

Route::get('/authenticate-logs', 'AuthenticateLogsController@authenticateLogs');
Route::get('/authenticate-logs-last-login-at', 'AuthenticateLogsController@lastLoginAt');
Route::get('/authenticate-logs-previous-login-at', 'AuthenticateLogsController@previousLoginAt');
Route::get('/authenticate-logs-last-login-ip', 'AuthenticateLogsController@lastLoginIp');