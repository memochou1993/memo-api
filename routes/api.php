<?php

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

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->middleware('auth:api');
    Route::get('user', 'AuthController@user')->middleware('auth:api');
});

Route::namespace('User')->middleware('auth:api')->prefix('users/me')->group(function () {
    Route::resource('records', 'RecordController')->except(['create', 'edit']);
});

Route::resource('users', 'UserController')->except(['create', 'edit']);
Route::resource('users.records', 'RecordController')->only(['index', 'show']);
