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

// Route::apiResource();

Route::apiResources([
    'users_api' => 'API\UserController',
    'doctors_api' => 'API\DoctorController' 
]);

Route::patch('/users_api/{users_api}/allergies',  'Api\UserController@updateAllergies')->name('users.allergies');
Route::patch('/users_api/{users_api}/chronics',  'Api\UserController@updateChronics')->name('users.chronics');
Route::patch('/users_api/{users_api}/change-password',  'Api\UserController@changePassword')->name('users.password');

Route::patch('/users_api/{users_api}/avatar-upload', 'Api\UserController@avatarUpload')->name('users.avatar_upload');
Route::get('/users_api/{users_api}/avatar-delete', 'Api\UserController@avatarDelete')->name('users.avatar_delete');
