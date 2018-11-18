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

Route::middleware('auth.jwt')->prefix('/patients')->group(function () {
    Route::get('{id?}', 'UserController@getUserInformationById');
    Route::prefix('family')->group(function () {
        Route::get('/{id}', 'FamilyController@getMembers');
        Route::post('add', 'FamilyController@addNewMember');
        Route::post('confirm', 'FamilyController@confirmMember');
    });
});

Route::middleware('auth.jwt')->prefix('/doctors')->group(function () {
    Route::get('{id}', 'DoctorController@getDoctor');
    Route::post('addnewpatient', 'DoctorController@addNewPatient');
    Route::delete('removepatient', 'DoctorController@removePatient');

    Route::prefix('admin')->group(function () {
        Route::put('update/{id}', 'DoctorController@updateInformation');
        Route::post('register', 'DoctorController@registerDoctor');
        Route::post('registervaccine', 'DoctorController@registerVaccine');
    });
});

Route::middleware('auth.jwt')->prefix('/vaccines')->group(function () {
    Route::get('/', 'VaccineController@getAllVaccines');
    Route::get('{id?}', 'VaccineController@getVaccine');
    Route::post('', 'VaccineController@addNewVaccine');
    Route::delete('', 'VaccineController@removeVaccine');
});

Route::prefix('/centers')->group(function () {
    Route::get('{id?}', 'CenterController@getCenterByCategory');
    Route::post('', 'CenterController@createNewCenter');
    Route::delete('', 'CenterController@removeCenter');

    Route::prefix('doctor')->group(function () {
        Route::post('confirm', 'CenterController@corfirmDoctor');
        Route::delete('remove/{id}', 'CenterController@removeDoctor');
    });

    Route::prefix('vaccines')->group(function () {
        Route::get('{vaccine}/{category}', 'CenterController@getVaccineCenters');
        Route::post('', 'CenterController@addNewVaccineToCenter');
    });
});
