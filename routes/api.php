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

/* Route::middleware('auth:api')->group('/auth', function (Request $request) {
    return $request->user();
});
*/

Route::prefix('/auth')->group(function () {
    Route::post('signin', 'UserController@signin');
    Route::post('signup', 'UserController@signup');
});
