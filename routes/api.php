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

Route::namespace('User')->middleware('auth:api')->prefix('users/me')->group(function () {
    Route::resource('records', 'RecordController')->except(['create', 'edit']);
});

Route::resource('users.records', 'RecordController')->only(['index', 'show']);
