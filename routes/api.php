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

Route::prefix('common')->namespace('Common')->group(function () {
    Route::post('upload', 'CommonController@upload');
});

Route::prefix('user')->namespace('Api')->group(function () {
    Route::any('index', 'UserController@index');
    Route::any('login', 'UserController@login');
});

Route::prefix('topic')->namespace('Api')->group(function () {
    Route::any('store', 'TopicController@store');
    Route::any('index', 'TopicController@index');
    Route::any('show', 'TopicController@show');
});

Route::prefix('comment')->namespace('Api')->group(function () {
    Route::any('index', 'CommentController@index');
    Route::any('store', 'CommentController@store');
});

