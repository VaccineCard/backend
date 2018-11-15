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
    Route::prefix('family')->group(function () {
        Route::post('add', 'FamilyController@AddMember');
        Route::post('confirm', 'FamilyController@ConfirmMember');
        Route::get('get', 'FamilyController@GetMembers');
    });
});

Route::prefix('/doctors')->group(function () {
    Route::get('{id?}', 'DoctorController@getDoctor');
    Route::post('add', 'DoctorController@AddDoctor');
    Route::delete('remove', 'DoctorController@Remove');

    Route::prefix('admin')->group(function () {
        Route::put('update/{id}', 'DoctorController@UpdateInformation');
        Route::post('register', 'DoctorController@RegisterDoctor');
        Route::post('registervaccine', 'DoctorController@RegisterVaccine');
    });
});


Route::prefix('/vaccines')->group(function () {
    Route::get('{id?}', 'VaccineController@getVaccine');
    Route::post('add', 'VaccineController@AddVaccine');
    Route::delete('remove', 'VaccineController@RemoveVaccine');
});

Route::prefix('/centers')->group(function () {
    Route::get('{id?}', 'CenterController@getCenter');
    Route::post('add', 'CenterController@AddCenter');
    Route::delete('remove/{id}', 'CenterController@RemoveCenter');

    Route::prefix('doctor')->group(function () {
        Route::post('add', 'CenterController@AddDoctor');
        Route::delete('remove/{id}', 'CenterController@RemoveDoctor');
    });
});
