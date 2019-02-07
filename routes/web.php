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

// ---- ADMIN RELATED ---------------->
Route::prefix('admin')->group(function(){
  Route::get('login',     'AppAdminController@adminLoginForm')->name('admin.login');
  Route::post('login',    'AppAdminController@adminLogin')->name('admin.login');
  Route::patch('logout',  'AppAdminController@adminLogout')->name('admin.logout');

  // Form: New Admin password change or change from Old to New password.
  Route::get('password',                'AppAdminController@passwordNewOrChangeForm')->name('admin.password');
  // Script: New Admin password change or change from Old to New password.
  Route::patch('password',              'AppAdminController@passwordNewOrChange')->name('admin.password');


  // ----  PASSWORD RESET RELATED ---------------->
  // 1. Form: To collect email for verification.
  Route::get('password-reset-form',     'AppAdminController@passwordResetEmailForm')->name('admin.password.reset-email-form');
  // 2. Script: To verify email and send Password Reset Link.
  Route::patch('password-reset-link',   'AppAdminController@passwordResetEmailLink')->name('admin.password.reset-email-link');
  // 3. Script: Links in from mail, verifies correctness of reset link payload and redirects to new password creation form.
  Route::get('password-reset-verify',   'AppAdminController@passwordResetEmailLinkVerify')->name('admin.password.reset-email-verify');
  // 4. Form: New password creation form.
  Route::get('password-reset-change',   'AppAdminController@passwordResetChangeForm')->name('admin.password.reset-change-form');
  // 5. Script: UPDATEs new password for admin.
  Route::patch('password-reset-change', 'AppAdminController@passwordResetChange')->name('admin.password.reset-change');
  // ---- ! PASSWORD RESET RELATED ---------------->
});
// ---- ADMIN RELATED ---------------->

// ---- APPOINTMENT RELATED ---------------->
Route::prefix('appointments')->group(function(){
Route::patch('/{appointment}/complete','AppointmentStatusController@complete')->name('appointments.complete');
Route::patch('/{appointment}/accept',  'AppointmentStatusController@accept')->name('appointments.accept');
Route::patch('/{appointment}/reject',  'AppointmentStatusController@reject')->name('appointments.reject');
Route::patch('/{appointment}/cancel',  'AppointmentStatusController@cancel')->name('appointments.cancel');
Route::patch('/{appointment}/payfee',  'AppointmentStatusController@payFee')->name('appointments.payfee');
});
// ---- APPOINTMENT RELATED ---------------->

Route::resource('specialties',   'SpecialtyController')->except('create','edit');
Route::resource('tags',          'TagController')->except('create','edit');
Route::resource('workplaces',    'WorkplaceController')->only('store','update','destroy');
Route::resource('applications',  'ApplicationController');
Route::resource('doctors',       'DoctorController');
Route::resource('documents',     'DocumentController');
Route::resource('schedules',     'ScheduleController')->only('store','update','destroy');
Route::resource('appointments',  'AppointmentController')->except('index');
Route::resource('messages',      'MessageController')->only('index','store','destroy');
Route::resource('prescriptions', 'PrescriptionController')->except('index');
Route::resource('drugs',         'DrugController');
Route::resource('reviews',       'ReviewController');
Route::resource('transactions',  'TransactionController')->except('index');
Route::resource('subscriptions', 'SubscriptionController')->except('index');

Route::get('processor-response', 'PaymentController@paymentResponse')->name('processor-response');

Route::get('adm-transactions',        'TransactionController@admindex')->name('adm_transactions');
Route::get('adm-subscriptions',       'SubscriptionController@admindex')->name('adm_subscriptions');
Route::get('mockedPayment/{transaction}', 'TransactionController@mockedPayment')->name('mockedPayment');
Route::get('mockedSubPayment/{subscription}', 'SubscriptionController@mockedPayment')->name('mockedSubPayment');
Route::get('applications/{application}/show-file', 'ApplicationController@showFile')->name('showFile');

Route::prefix('{user}')->group(function(){
  Route::get('/appointments',    'AppointmentController@index')->name('appointments.index');
  Route::get('/prescriptions',   'PrescriptionController@index')->name('prescriptions.index');
  Route::get('/transactions',    'TransactionController@index')->name('transactions.index');
  Route::get('/subscriptions',   'SubscriptionController@index')->name('subscriptions.index');
});
Route::prefix('{doctor}')->group(function(){
  Route::get('/dr-appointments',   'AppointmentController@drindex')->name('dr_appointments');
  Route::get('/dr-prescriptions',  'PrescriptionController@drindex')->name('dr_prescriptions');
  Route::get('/dr-transactions',   'TransactionController@drindex')->name('dr_transactions'); 
  
  Route::patch('/revoke','AppAdminController@licenseRevoke')->name('revoke_license');
  Route::patch('/restore','AppAdminController@licenseRestore')->name('restore_license'); 
});

Route::get('schedules/{doctor}/{day}', 'ScheduleController@schedules');


// ---- ADMIN ACL RELATED ---------------->
Route::prefix('make/{user}')->group(function(){
  Route::patch('/admin', 'AppAdminController@makeAdmin')->name('make-admin');
  Route::patch('/staff', 'AppAdminController@makeStaff')->name('make-staff');
  Route::patch('/normal','AppAdminController@makeNormal')->name('make-normal');
});
// ---- ADMIN ACL RELATED ---------------->


// ---- MOBILPAY RELATED ---------------->
Route::prefix('mobilpay')->group(function(){
  Route::get('/{model}/pay',     'PaymentController@mobilpayRequestRedirect')->name('mobilpay_pay');
  Route::post('/confirm', 'PaymentController@mobilpayConfirm')->name('mobilpay_confirm');
  Route::post('/return',  'PaymentController@mobilpayReturn')->name('mobilpay_return');
});
// ---- MOBILPAY RELATED ---------------->



Route::prefix('dashboard')->group(function(){
  Route::get('/',             'DashboardController@index')->name('dashboard-main');
  Route::get('/users',        'DashboardController@users')->name('dashboard-users');
  Route::get('/doctors',      'DashboardController@doctors')->name('dashboard-doctors');
  Route::get('/admins',       'DashboardController@admins')->name('dashboard-admins');
  Route::get('/transactions', 'DashboardController@transactions')->name('dashboard-transactions');
  
  Route::get('/list-admins',  'DashboardController@listAdmins')->name('list-admins');
  Route::get('/list-staffs',  'DashboardController@listStaffs')->name('list-staffs');
});

Route::prefix('searches')->group(function(){
  Route::get('/',            'SearchController@index')->name('search');
  Route::get('/doctors',     'SearchController@doctors')->name('search.doctors');
  Route::get('/tags',        'SearchController@tags')->name('search.tags');
  Route::get('/specialties', 'SearchController@specialties')->name('search.specialties');
  Route::get('/users',       'SearchController@users')->name('search.users');
});



// ---- IMAGE UPLOADS RELATED ---------------->
Route::prefix('{user}')->group(function(){
  Route::patch('/image-upload',     'UserController@imageUpload')->name('image.upload');
  Route::patch('/avatar-upload',    'UserController@avatarUpload')->name('user.avatar.upload');
  Route::get('/avatar-delete',      'UserController@avatarDelete')->name('user.avatar.delete');
  
  Route::patch('/block','AppAdminController@blockUser')->name('block_user');
  Route::patch('/unblock','AppAdminController@unblockUser')->name('unblock_user');
});

Route::get('image/{image}',         'ImageController@destroy')->name('image.destroy');
//!---- IMAGE UPLOADS RELATED ---------------->

Route::get('user-dashboard',        'PatientController@dashboard')->name('user_dashboard');
Route::get('admin-dashboard', function(){return view('admin.dashboard');})->name('admin_dashboard')->middleware('auth');

Route::prefix('{user}')->group(function(){
  Route::patch('/allergies',        'UserController@updateAllergies')->name('allergies.update');
  Route::patch('/chronics',         'UserController@updateChronics')->name('chronics.update');
  Route::patch('/change-password',  'UserController@changePassword')->name('password.update');

  Route::get('/edit',           'UserController@edit')->name('users.edit');
  Route::patch('/',             'UserController@update')->name('users.update');
  Route::delete('/',            'UserController@destroy')->name('users.destroy');

  Route::get('/notifs',         'NotificationsController@index')->name('notifications.index');
  Route::get('/notifications',  'NotificationsController@display')->name('notifications.display');

  Route::get('/',               'UserController@show')->name('users.show');
});

Route::post('/verify_resend',   'UserController@resend')->name('verify_resend');
Route::post('/email_verified',  'UserController@verified')->name('email_verified');