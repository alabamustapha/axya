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

// Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

Route::resource('specialties', 'SpecialtyController')->except('create','edit');
Route::resource('tags',        'TagController')->except('create','edit');
Route::resource('workplaces',  'WorkplaceController')->only('store','update','destroy');
Route::resource('applications','ApplicationController');
Route::resource('doctors',     'DoctorController');
Route::resource('documents',   'DocumentController');



// ---- ADMIN ACL RELATED ---------------->
Route::prefix('make')->group(function(){
Route::patch('/{user}/admin', 'AppAdminController@makeAdmin')->name('make-admin');
Route::patch('/{user}/staff', 'AppAdminController@makeStaff')->name('make-staff');
Route::patch('/{user}/normal', 'AppAdminController@makeNormal')->name('make-normal');
});
// ---- ADMIN ACL RELATED ---------------->


Route::prefix('dashboard')->group(function(){
  Route::get('/',        'DashboardController@index')->name('dashboard-main');
  Route::get('/users',  'DashboardController@users')->name('dashboard-users');
  Route::get('/doctors','DashboardController@doctors')->name('dashboard-doctors');
  Route::get('/admins', 'DashboardController@admins')->name('dashboard-admins');
  Route::get('/transactions', 'DashboardController@transactions')->name('dashboard-transactions');  
});
Route::get('applications/{application}/show-file', 'ApplicationController@showFile')->name('showFile');



// ---- IMAGE UPLOADS RELATED ---------------->
Route::patch('{user}/image-upload', 'UserController@imageUpload')->name('image.upload');

Route::patch('{user}/avatar-upload', 'UserController@avatarUpload')->name('user.avatar.upload');
Route::get('{user}/avatar-delete', 'UserController@avatarDelete')->name('user.avatar.delete');

Route::get('image/{image}', 'ImageController@destroy')->name('image.destroy');
//!---- IMAGE UPLOADS RELATED ---------------->

Route::get('user-dashboard', function(){return view('users.dashboard');})->name('user_dashboard')->middleware('auth');
Route::get('admin-dashboard', function(){return view('admin.dashboard');})->name('admin_dashboard')->middleware('auth');

Route::patch('/{user}/allergies',  'UserController@updateAllergies')->name('allergies.update');
Route::patch('/{user}/chronics',  'UserController@updateChronics')->name('chronics.update');
Route::patch('/{user}/change-password',  'UserController@changePassword')->name('password.update');

Route::get('/{user}/edit',   'UserController@edit')->name('users.edit');
Route::patch('/{user}',      'UserController@update')->name('users.update');
Route::delete('/{user}',     'UserController@destroy')->name('users.destroy');

Route::get('/{user}/notifs', 'NotificationsController@index')->name('notifications.index');
Route::get('/{user}/notifications', 'NotificationsController@display')->name('notifications.display');

Route::get('/{user}', 'UserController@show')->name('users.show');