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

Route::get('/settings', '\QCod\AppSettings\Controllers\AppSettingController@index')->name('app-settings')->middleware('superadmin');

Route::get('/nova');

// Route::get('{path}', 'HomeController@search')->where('path', '([A-z\d-\/_.]+)?');

Auth::routes(['verify' => true]);

// ---- ADMIN RELATED ---------------->
Route::prefix('admin')->group(function(){
  Route::get('login',     'AdminAuthController@adminLoginForm')->name('admin.login');
  Route::post('login',    'AdminAuthController@adminLogin')->name('admin.login');
  Route::patch('logout',  'AdminAuthController@adminLogout')->name('admin.logout');

  // Form: New Admin password change or change from Old to New password.
  // Script: New Admin password change or change from Old to New password.
  Route::get('password',                'AdminAuthController@passwordNewOrChangeForm')->name('admin.password');
  Route::patch('password',              'AdminAuthController@passwordNewOrChange')->name('admin.password');


  /**
   * ----  ADMINS PASSWORD ADMINSTRATION ---------------->
   * 1. Form: To collect email for verification.
   * 2. Script: To verify email and send Password Reset Link.
   * 3. Script: Links in from mail, verifies correctness of reset link payload and redirects to new password creation form.
   * 4. Form: New password creation form.
   * 5. Script: UPDATEs new password for admin.
   */
  Route::get('password-reset-form',     'AdminAuthController@passwordResetEmailForm')->name('admin.password.reset-email-form');         // 1.
  Route::patch('password-reset-link',   'AdminAuthController@passwordResetEmailLink')->name('admin.password.reset-email-link');         // 2.
  Route::get('password-reset-verify',   'AdminAuthController@passwordResetEmailLinkVerify')->name('admin.password.reset-email-verify'); // 3.
  Route::get('password-reset-change',   'AdminAuthController@passwordResetChangeForm')->name('admin.password.reset-change-form');       // 4.
  Route::patch('password-reset-change', 'AdminAuthController@passwordResetChange')->name('admin.password.reset-change');                // 5.
  // ---- ! ADMINS PASSWORD ADMINSTRATION ---------------->
});
// ----! ADMIN RELATED ---------------->

// ---- DOCTOR RELATED ---------------->
Route::prefix('doctors')->group(function(){
  Route::get('login',     'AppDoctorController@doctorLoginForm')->name('doctor.login');
  Route::post('login',    'AppDoctorController@doctorLogin')->name('doctor.login');
  Route::patch('logout',  'AppDoctorController@doctorLogout')->name('doctor.logout');

  // Form: New Doctor password change or change from Old to New password.
  Route::get('password',                'AppDoctorController@passwordNewOrChangeForm')->name('doctor.password');
  // Script: New Doctor password change or change from Old to New password.
  Route::patch('password',              'AppDoctorController@passwordNewOrChange')->name('doctor.password');


  /**
   * ----  DOCTORS PASSWORD ADMINSTRATION ---------------->
   * 1. Form: To collect email for verification.
   * 2. Script: To verify email and send Password Reset Link.
   * 3. Script: Links in from mail, verifies correctness of reset link payload and redirects to new password creation form.
   * 4. Form: New password creation form.
   * 5. Script: UPDATEs new password for doctor.
   */
  Route::get('password-reset-form',     'AppDoctorController@passwordResetEmailForm')->name('doctor.password.reset-email-form');         // 1.
  Route::patch('password-reset-link',   'AppDoctorController@passwordResetEmailLink')->name('doctor.password.reset-email-link');         // 2.
  Route::get('password-reset-verify',   'AppDoctorController@passwordResetEmailLinkVerify')->name('doctor.password.reset-email-verify'); // 3.
  Route::get('password-reset-change',   'AppDoctorController@passwordResetChangeForm')->name('doctor.password.reset-change-form');       // 4.
  Route::patch('password-reset-change', 'AppDoctorController@passwordResetChange')->name('doctor.password.reset-change');                // 5.
  // ---- ! DOCTORS PASSWORD ADMINSTRATION ---------------->
  
  Route::prefix('{doctor}')->group(function(){
    Route::get('/dashboard',    'DoctorController@dashboard')->name('dr_dashboard');
    Route::get('/appointments', 'AppointmentController@drindex')->name('dr_appointments');
    Route::get('/prescriptions','PrescriptionController@drindex')->name('dr_prescriptions');
    Route::get('/transactions', 'TransactionController@drindex')->name('dr_transactions'); 
    Route::get('/patients',     'DoctorController@patients')->name('dr_patients'); 
    Route::get('/messages/{appointment?}', 'MessageController@drindex')->name('dr_messages');
    
    Route::patch('/revoke','AppDoctorController@licenseRevoke')->name('revoke_license');
    Route::patch('/restore','AppDoctorController@licenseRestore')->name('restore_license'); 
  });
});
// ----! DOCTOR RELATED ---------------->

// ---- APPOINTMENT RELATED ---------------->
Route::prefix('appointments')->group(function(){
  Route::patch('/{appointment}/complete','AppointmentStatusController@complete')->name('appointments.complete');
  Route::patch('/{appointment}/accept',  'AppointmentStatusController@accept')->name('appointments.accept');
  Route::patch('/{appointment}/reject',  'AppointmentStatusController@reject')->name('appointments.reject');
  Route::patch('/{appointment}/cancel',  'AppointmentStatusController@cancel')->name('appointments.cancel');
  Route::patch('/{appointment}/payfee',  'AppointmentStatusController@payFee')->name('appointments.payfee');
});
// ----! APPOINTMENT RELATED ---------------->

Route::resource('specialties',   'SpecialtyController')->except('create','edit');
Route::resource('tags',          'TagController')->except('create','edit');
Route::resource('workplaces',    'WorkplaceController')->only('store','update','destroy');
Route::resource('applications',  'ApplicationController');
Route::resource('doctors',       'DoctorController');
Route::resource('documents',     'DocumentController');
Route::resource('schedules',     'ScheduleController')->only('index','store','update','destroy');
Route::resource('appointments',  'AppointmentController')->except('index','create','edit');
Route::resource('prescriptions', 'PrescriptionController')->except('index');
Route::resource('drugs',         'DrugController');
Route::resource('reviews',       'ReviewController');
Route::resource('subscriptions', 'SubscriptionController')->except('index');
Route::resource('subscription_plans', 'SubscriptionPlanController')->except('create', 'edit');
Route::resource('medications',   'MedicationController')->except('create', 'edit');
  
Route::prefix('{user}')->group(function() {
  Route::resource('transactions',  'TransactionController')->except('index');
  Route::resource('events',        'CalendarEventController')->only('index', 'destroy');
});


Route::get('processor-response', 'PaymentController@paymentResponse')->name('processor-response');


Route::get('mockedPayment/{transaction}', 'TransactionController@mockedPayment')->name('mockedPayment');
Route::get('mockedSubPayment/{subscription}', 'SubscriptionController@mockedPayment')->name('mockedSubPayment');
Route::get('applications/{application}/show-file', 'ApplicationController@showFile')->name('showFile');


Route::prefix('{user}')->group(function(){
  Route::get('/appointments',    'AppointmentController@index')->name('appointments.index');
  Route::get('/prescriptions',   'PrescriptionController@index')->name('prescriptions.index');
  Route::get('/transactions',    'TransactionController@index')->name('transactions.index');
  Route::get('/subscriptions',   'SubscriptionController@index')->name('subscriptions.index');
});

Route::get('schedulesByDay/{doctorId}/{dayId}', 'ScheduleController@schedulesByDay')->name('schedules.day');
// Route::get('schedulesByDay/{doctorId}/{dayId}', 'ScheduleController@serializedSchedulesByDay');


// ## JSON RESPOBSES
// ---- ADMIN ACL RELATED ---------------->
Route::prefix('make/{user}')->group(function(){
  Route::patch('/admin', 'AppAdminController@makeAdmin')->name('make-admin');
  Route::patch('/staff', 'AppAdminController@makeStaff')->name('make-staff');
  Route::patch('/normal','AppAdminController@makeNormal')->name('make-normal');
});
// ----! ADMIN ACL RELATED ---------------->


// ---- MOBILPAY RELATED ---------------->
Route::prefix('mobilpay')->group(function(){
  Route::get('/{model}/pay',     'PaymentController@mobilpayRequestRedirect')->name('mobilpay_pay');
  Route::get('/confirm', 'PaymentController@mobilpayConfirm')->name('mobilpay_confirm');
  Route::get('/return',  'PaymentController@mobilpayReturn')->name('mobilpay_return');
});
// ---- MOBILPAY RELATED ---------------->



Route::prefix('dashboard')->group(function(){
  Route::get('/',             'DashboardController@index')->name('dashboard-main');
  Route::get('/users',        'DashboardController@users')->name('dashboard-users');
  Route::get('/doctors',      'DashboardController@doctors')->name('dashboard-doctors');
  Route::get('/admins',       'DashboardController@admins')->name('dashboard-admins');

  Route::get('adm-transactions',        'TransactionController@admindex')->name('adm_transactions');
  Route::get('adm-subscriptions',       'SubscriptionController@admindex')->name('adm_subscriptions');
  
  Route::get('/transactions', 'DashboardController@transactions')->name('dashboard-transactions');
  Route::get('/subscriptions','DashboardController@subscriptions')->name('dashboard-subscriptions');

  Route::get('/appointments', 'DashboardController@appointments')->name('dashboard-appointments');
  
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


Route::get('user-dashboard',        'PatientController@dashboard')->name('user_dashboard');
Route::get('admin-dashboard', function(){return view('admin.dashboard');})->name('admin_dashboard')->middleware('auth');
// ----  DASHBOARDS RELATED ---------------->

Route::get('image/{image}',         'ImageController@destroy')->name('image.destroy');
// ----! IMAGES RELATED ---------------->

Route::prefix('messages')->group(function(){
  Route::get('/{user}/{appointment?}', 'MessageController@index')->name('messages.index');
  Route::post('/{appointment}', 'MessageController@store')->name('messages.store');
  Route::post('/{appointment}/chat-file-upload', 'MessageController@fileUpload')->name('chat.file.upload');
  Route::delete('/{message}',  'MessageController@destroy')->name('messages.destroy');
});
// ----! USER MESSAGES RELATED ---------------->

Route::prefix('{user}')->group(function(){

  Route::get('/appointments',    'AppointmentController@index')->name('appointments.index');
  Route::get('/prescriptions',   'PrescriptionController@index')->name('prescriptions.index');
  Route::get('/transactions',    'TransactionController@index')->name('transactions.index');
  Route::get('/subscriptions',   'SubscriptionController@index')->name('subscriptions.index');
// ----! USERS RELATED MODELS INDEXES ---------------->

  Route::patch('/avatar-upload',    'UserController@avatarUpload')->name('user.avatar.upload');
  Route::get('/avatar-delete',      'UserController@avatarDelete')->name('user.avatar.delete');
// ----! IMAGE UPLOADS RELATED ---------------->
  
  Route::patch('/block','AppAdminController@blockUser')->name('block_user');
  Route::patch('/unblock','AppAdminController@unblockUser')->name('unblock_user');
// ----! USER BLOCK/UNBLOCK RELATED ---------------->


  Route::get('/doctors',            'UserController@doctors')->name('user.doctors'); 
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