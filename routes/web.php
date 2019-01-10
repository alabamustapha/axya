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
Route::get('/nova');

// Route::get('{path}', 'HomeController@search')->where('path', '([A-z\d-\/_.]+)?');

Auth::routes(['verify' => true]);

// ---- APPOINTMENT RELATED ---------------->
Route::prefix('appointments')->group(function(){
Route::patch('/{appointment}/complete','AppointmentStatusController@complete')->name('appointments.complete');
Route::patch('/{appointment}/accept',  'AppointmentStatusController@accept')->name('appointments.accept');
Route::patch('/{appointment}/reject',  'AppointmentStatusController@reject')->name('appointments.reject');
Route::patch('/{appointment}/cancel',  'AppointmentStatusController@cancel')->name('appointments.cancel');
Route::patch('/{appointment}/payfee',  'AppointmentStatusController@payFee')->name('appointments.payfee');
});
// ---- APPOINTMENT RELATED ---------------->

Route::resource('specialties', 'SpecialtyController')->except('create','edit');
Route::resource('tags',        'TagController')->except('create','edit');
Route::resource('workplaces',  'WorkplaceController')->only('store','update','destroy');
Route::resource('applications','ApplicationController');
Route::resource('doctors',     'DoctorController');
Route::resource('documents',   'DocumentController');
Route::resource('schedules',   'ScheduleController')->only('store','update','destroy');
Route::resource('appointments','AppointmentController');
Route::get('dr-appointments',  'AppointmentController@drindex')->name('dr_appointments');
Route::resource('messages',    'MessageController')->only('index','store','destroy');
Route::resource('prescriptions','PrescriptionController');
Route::get('dr-prescriptions',  'PrescriptionController@drindex')->name('dr_prescriptions');
Route::resource('drugs',       'DrugController');
Route::resource('reviews',     'ReviewController');
Route::resource('transactions',       'TransactionController')->except('index');
Route::get('/{user}/transactions',    'TransactionController@index')->name('transactions.index');
Route::get('/{user}/dr-transactions', 'TransactionController@drindex')->name('dr_transactions');
Route::get('adm-transactions',        'TransactionController@admindex')->name('adm_transactions');
Route::get('mockedPayment/{transaction}', 'TransactionController@mockedPayment')->name('mockedPayment');

Route::resource('subscriptions',      'SubscriptionController');
Route::get('adm-subscriptions',       'SubscriptionController@admindex')->name('adm_subscriptions');
Route::get('mockedPayment/{subscription}', 'SubscriptionController@mockedPayment')->name('mockedPayment');

Route::get('schedules/{doctor}/{day}', 'ScheduleController@schedules');


// ---- ADMIN ACL RELATED ---------------->
Route::prefix('make')->group(function(){
Route::patch('/{user}/admin', 'AppAdminController@makeAdmin')->name('make-admin');
Route::patch('/{user}/staff', 'AppAdminController@makeStaff')->name('make-staff');
Route::patch('/{user}/normal','AppAdminController@makeNormal')->name('make-normal');
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

Route::get('searches',        'SearchController@index')->name('search');
Route::get('searches/doctors','SearchController@doctors')->name('search.doctors');
Route::get('searches/tags',   'SearchController@tags')->name('search.tags');
Route::get('searches/specialties', 'SearchController@specialties')->name('search.specialties');
Route::get('searches/users',  'SearchController@users')->name('search.users');



// ---- IMAGE UPLOADS RELATED ---------------->
Route::patch('{user}/image-upload', 'UserController@imageUpload')->name('image.upload');

Route::patch('{user}/avatar-upload', 'UserController@avatarUpload')->name('user.avatar.upload');
Route::get('{user}/avatar-delete', 'UserController@avatarDelete')->name('user.avatar.delete');

Route::get('image/{image}', 'ImageController@destroy')->name('image.destroy');
//!---- IMAGE UPLOADS RELATED ---------------->

Route::get('user-dashboard', 'PatientController@dashboard')->name('user_dashboard');
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
Route::post('/verify_resend', 'UserController@resend')->name('verify_resend');
Route::post('/email_verified', 'UserController@verified')->name('email_verified');