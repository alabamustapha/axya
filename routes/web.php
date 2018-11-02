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

Route::get('/', function () { return view('welcome'); })->name('home');

Auth::routes(['verify' => true]);

Route::get('user-dashboard', function(){return view('users.dashboard');})->name('user_dashboard')->middleware('auth');
Route::get('admin-dashboard', function(){return view('admin.dashboard');})->name('admin_dashboard')->middleware('auth');
Route::get('/dhb/{user}', 'PatientController@dashboard')->name('patient_dashboard');

Route::patch('/{user}/allergies',  'UserController@updateAllergies')->name('allergies.update');
Route::patch('/{user}/chronics',  'UserController@updateChronics')->name('chronics.update');
Route::patch('/{user}/change-password',  'UserController@changePassword')->name('password.update');

Route::get('{user}/edit',   'UserController@edit')->name('users.edit');
Route::patch('{user}',      'UserController@update')->name('users.update');
Route::delete('{user}',     'UserController@destroy')->name('users.destroy');

Route::get('{user}/notifs', 'NotificationsController@index')->name('notifications.index');
Route::get('{user}/notifications', 'NotificationsController@display')->name('notifications.display');

Route::get('{user}', 'UserController@show')->name('users.show');