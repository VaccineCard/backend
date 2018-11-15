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
    Route::post('signin', 'AuthController@signin');
    Route::post('signup', 'AuthController@signup');
});

Route::prefix('/locations')->group(function () {
    Route::prefix('countries')->group(function () {
        Route::get('/', 'LocationController@getCountries');
        Route::get('{id?}', 'LocationController@getCountry');
        Route::get('{id?}/states', 'LocationController@getStates');
        Route::get('states/{id?}', 'LocationController@getState');
    });
});

Route::prefix('/patients')->group(function () {
    Route::get('{id?}', 'UserController@getUserInformationById');
    Route::get('{id}/vaccines', 'UserController@getAllUserVaccines');
    Route::prefix('family')->group(function () {
        Route::get('{id?}', 'FamilyController@getMembers');
        Route::post('add', 'FamilyController@addMember');
        Route::post('confirm', 'FamilyController@confirmMember');
    });
});

Route::prefix('/doctors')->group(function () {
    Route::get('{id?}', 'DoctorController@getDoctor');
    Route::post('add', 'DoctorController@addDoctor');
    Route::delete('remove', 'DoctorController@removeDoctor');

    Route::prefix('admin')->group(function () {
        Route::put('update/{id}', 'DoctorController@updateInformation');
        Route::post('register', 'DoctorController@registerDoctor');
        Route::post('registervaccine', 'DoctorController@registerVaccine');
    });
});


Route::prefix('/vaccines')->group(function () {
    Route::get('{id?}', 'VaccineController@getVaccine');
    Route::post('add', 'VaccineController@addVaccine');
    Route::delete('remove', 'VaccineController@removeVaccine');
});

Route::prefix('/centers')->group(function () {
    Route::get('{id?}', 'CenterController@getCenter');
    Route::post('add', 'CenterController@addCenter');
    Route::delete('remove/{id}', 'CenterController@removeCenter');

    Route::prefix('doctor')->group(function () {
        Route::post('add', 'CenterController@addDoctor');
        Route::delete('remove/{id}', 'CenterController@removeDoctor');
    });
});
