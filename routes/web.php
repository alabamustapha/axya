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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes(['verify' => true]);

Route::get('user-dashboard', function(){return view('users.show');})->name('dashboard')->middleware('auth');
Route::get('admin-dashboard', function(){return view('admin.dashboard');})->name('admin_dashboard')->middleware('auth');
Route::get('/{user}', 'PatientController@dashboard')->name('patient_dashboard');

Route::get('{user}/notifs', 'NotificationsController@index')->name('notifications.index');
Route::get('{user}/notifications', 'NotificationsController@display')->name('notifications.display');
