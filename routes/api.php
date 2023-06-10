<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* AUTH */
Route::namespace('App\Http\Controllers\Auth')->group(function() {
    Route::prefix('auth')->name('auth.')->group(function() {
        Route::post('token', 'AuthPassportController@token');
        Route::middleware('auth:api')->group(function () {
            Route::get('logout', 'AuthPassportController@logout');
        });
    });
});

/* USERS */
Route::middleware('auth:api')->namespace('App\Http\Controllers\User')->group(function() {
    Route::prefix('users')->name('users.')->group(function() {
        Route::post('search/email-dni', 'UserController@searchByEmailOrDNI');
        Route::post('greet', 'UserController@greet');
    });
    Route::apiResource('users', 'UserController');
});
