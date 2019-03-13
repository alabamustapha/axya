<?php

namespace App;

use App\Doctor;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
use Laravel\Nova\Actions\Actionable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Sluggable, HasApiTokens, Actionable;

    protected $dates = ['dob','application_retry_at'];

    protected $casts = [
        'dob' => 'date:Y-m-d',
        'email_verified_at' => 'datetime',
    ]; 

    protected $appends = ['link','is_verified',
      'is_superadmin','is_admin','is_administrator','is_staff',
      'is_authenticated_superadmin','is_authenticated_admin','is_authenticated_staff',
      'is_doctor','is_potential_doctor',
      'type','status','doctors_count',
      'appointments_count','transactions_count','subscriptions_count',
      'appointments_list','transactions_list','subscriptions_list','prescriptions_list',
      'completed_appointments_list','upcoming_appointments_list','pending_appointments_list',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','slug','email','password','address','phone',
        'gender','avatar','blocked','dob','weight','height','allergies','chronics',
        'last_four','terms','application_retry_at',
        'verification_link','as_doctor','application_status',
        'admin_mode','admin_password','doctor_mode','doctor_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'acl', 'last_four',
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
                            ->orderBy('created_at', 'desc');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function calendar_events()
    {
        return $this->hasMany(CalendarEvent::class);
    }

    /**
     * Route key
     * 
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }



    public function getFirstNameAttribute($value)
    {
      $fname = explode(' ', $this->name);

      return current($fname);
    }

    public function getLastNameAttribute($value)
    {
       $lname = explode(' ', $this->name);
       
       return end($lname);
    }

    public function getAvatarAttribute($value)
    {
        return (is_null($value) || $value == 'images/doc.jpg') 
                ? config('app.url') . '/images/doc.jpg' 
                : $value
                ;
    }

    public function getOriginalAvatarFileAttribute($value)
    {
        return $this->hasUploadedAvatar() 
          ? $this->documents()
               ->where('documentable_id', $this->id)
               ->where('documentable_type', 'App\User')
               ->first()
               ->url
          :'#';
        // ? $this->images()->first()->url:'#';
    }

    public function hasUploadedAvatar()
    {
        return $this->avatar !== config('app.url') . '/images/doc.jpg';
    }

    public function inconclusiveAppointments()
    {
        return $this->appointments()->whereIn('status', [0,2])->get();
    }

    public function hasInconclusiveAppointmentWithSameDoctor($doctorId)
    {
        return !! $this->appointments()
                    ->whereIn('status', [0,2])
                    ->where('doctor_id', $doctorId)
                    ->count()
                    ;
    }

    /**
     * Check if logged in user is the present resource owner.
     * 
     * @return boolean
     */
    public function isAccountOwner()
    {
        return $this->id == auth()->id();
    }

    /**
     * Check if logged in user is the present resource owner.
     * 
     * @return boolean
     */
    public function isVerified()
    {
        return !is_null($this->email_verified_at);

        // return app()->environment('local')
        //     ? ( 
        //       !is_null($this->email_verified_at) || 
        //       $this->email == 'cucuteanu@yahoo.com' || 
        //       $this->email == 'alabamustapha@gmail.com' || 
        //       $this->email == 'tonyfrenzy@gmail.com' || 
        //       $this->email == 'solomoneyitene@gmail.com'
        //       )
        //     : !is_null($this->email_verified_at)
        //     ;
    }
    public function isSuspended()
    {
        return $this->blocked == '1';
    }


    /**
     * If user is admin/staff/doctor and is logged in as admin/doctor, log him out. 
     * Persistent log in could be due to session expiration.
     *
     * @return void
     */
    public function logOutAsAdminOrDoctor()
    {
        if (Auth::check() && Auth::id() == $this->id) {
            if ($this->isAdmin() || $this->isStaff()) {
                $this->update(['admin_mode' => 0]);
            }

            if ($this->isDoctor()) {
                $this->update(['doctor_mode' => 0]);
            }

            return;
        }
    }

    /**
     * Is a male user.
     */
    public function scopeMaleMembers($query)
    {
        return $query->where('gender', 'Male');
    }

    /**
     * Is a female user.
     */
    public function scopeFemaleMembers($query)
    {
        return $query->where('gender', 'Female');
    }

    /**
     * Is a user of other sexuality.
     */
    public function scopeOtherGenders($query)
    {
        return $query->where('gender', 'Other');
    }

    /**
     * Has verified email address.
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * Has not verified email address.
     */
    public function scopeNotVerified($query)
    {
        return $query->whereNull('email_verified_at');
    }


    /**
     * Get actual age.
     * 
     * @return integer
     */
    public function age()
    {
        return is_null($this->dob) ? 0 : $this->dob->diffInYears(\Carbon\Carbon::now());
    }

    /**
     * Get actual age, date without h:m:s.
     * 
     * @return string
     */
    public function dob()
    {
        return is_null($this->dob) ? 'not set' : substr($this->dob, 0, 10);
    }


    /* --- - Access Control Levels - --- */

    /**
     * Check a user's authorization level.
     * 
     * @return boolean
     */

    public function scopeAdmin($query)
    {
        return $query->whereIn('acl', ['1','5']);
    }

    public function scopeStaff($query)
    {
        return $query->where('acl', '2');
    }



    /**
     * A Super Admin but not signed in as ADMIN
     * 
     * @return  boolean
     */
    public function isSuperAdmin() 
    {
        return $this->is_verified && ($this->acl == '5');
    }

    /**
     * A Basic Admin but not signed in as ADMIN
     * 
     * @return  boolean
     */
    public function isAdmin() 
    {
        return $this->is_verified && ($this->acl == '1' || $this->isSuperAdmin());
    }

    /**
     * A Staff but not signed in as STAFF-ADMIN
     * 
     * @return  boolean
     */
    public function isStaff() 
    {
        return $this->is_verified && ($this->acl == '2' || $this->isAdmin()); 
    }

    public function isAdministrator() 
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    /**
     * Check the ADMIN LOG IN status of this user.
     * 
     * @return  boolean
     */
    public function isLoggedInAsAdmin() 
    {
        return !! ($this->admin_mode == '1' && !is_null($this->admin_password));
    }

    /**
     * A Super Admin and is signed in as ADMIN
     * 
     * @return  boolean
     */
    public function isAuthenticatedSuperAdmin() 
    {
        return $this->isSuperAdmin() && $this->isLoggedInAsAdmin();
    }

    /**
     * A Basic Admin and is signed in as ADMIN
     * 
     * @return  boolean
     */
    public function isAuthenticatedAdmin() 
    {
        return $this->isAdmin() && $this->isLoggedInAsAdmin();

        // return $this->is_verified && app()->environment('local') 
        //     ? (
        //       $this->acl == '1' || 
        //       $this->isAuthenticatedSuperAdmin() || 
        //       $this->email == 'cucuteanu@yahoo.com' || 
        //       $this->email == 'alabamustapha@gmail.com' || 
        //       $this->email == 'tonyfrenzy@gmail.com' || 
        //       $this->email == 'solomoneyitene@gmail.com' 
        //       )
        //     : $this->acl == '1' || $this->isAuthenticatedSuperAdmin()
        //     ;
    }

    public function isAuthenticatedStaff() 
    {
        return $this->isStaff() && $this->isLoggedInAsAdmin();        
    }

    /**
     * Check the DOCTOR LOG IN status of this user.
     * 
     * @return  boolean
     */
    public function isLoggedInAsDoctor() 
    {
        return !! ($this->doctor_mode == '1' && !is_null($this->doctor_password));
    }

    public function isDoctor() 
    {
        // return !! $this->has('doctor')->count();
        return !! $this->doctor()->count();
    }

    public function isAuthenticatedDoctor() 
    {
        return $this->isDoctor() && $this->isLoggedInAsDoctor();        
    }

    public function isActiveDoctor() 
    {
        return $this->isDoctor() && $this->doctor()->isActive();
    }

    public function isSuspendedDoctor() 
    {
        return $this->isDoctor() && $this->doctor()->isSuspended();
    }


    /**
     * Change a user's authorization level.
     * 
     * @return null
     */
    public function changeAclTo($level) 
    {
        switch ($level) {
          case 'normal':
            $this->acl = '3';
            // $this->update();
            break;

          case 'staff':
            $this->acl = '2';
            // $this->update();
            break;

          case 'admin':
            $this->acl = '1';
            // $this->update();
            break;
        }
        $this->update();
    } 

    // public function makeOrdinaryMember() 
    // {
    //     $this->acl = '3';
    //     $this->update();
    // } 

    // public function makeStaff() 
    // {
    //     $this->acl = '2';
    //     $this->update();
    // }

    // public function makeAdmin() 
    // {
    //     $this->acl = '1';
    //     $this->update();
    // }

    public function block() 
    {
        $this->blocked = '1';
        $this->update();
    }

    public function unblock() 
    {
        $this->blocked = '0';
        $this->update();
    }


    /* --- - User Roles - --- */

    /**
     * Prints out a user's authorization level.
     * 
     * @return null
     */
    public function type() 
    {
        if ($this->acl == '1'){
            return 'Admin';
        } 
        elseif ($this->acl == '5'){
            return 'Admin*';
        } 
        elseif ($this->acl == '2'){
            return 'Staff';
        }
        elseif ($this->acl == '3'){
            return 'Normal';
        }
    }

    public function professionalType() 
    {
        return $this->isDoctor() ? 'Doctor':'User';
    }


    /*<!---------------- Update Doctor Application Status ---------------->*/
    public static $applicationStatus = array(
        0 => 'Are you a <i class="fa fa-user-md"></i> Medical Doctor? 
              <a class="btn btn-success btn-sm" href="http://axya.be-healthy.ro/doctors/create">Register Here!</a>',

        1 => '<span class="teal text-bold"><i class="fa fa-info-circle"></i>&nbsp; Notifications</span>
              <hr> 
              <small style="font-size:12px;">
                Notifications and updates on professional stuffs.
                <br>
                <small class="red"><em>You may recieve appiontment from patients now.</em></small>
                <br>
                <small class="red"><em>You must be <b>subscribed</b> to appear in search results.</em></small>
              </small>',

        2 => '<span class="green text-bold"><i class="fa fa-info-circle"></i>&nbsp; Application Accepted</span>
              <hr>
              <small style="font-size:12px;">
                Your information has been <b>verified</b>, your application is <b>accepted</b> 
                <br>
                You can now attend to patients and receive appointments on this platform after subscription.
                <button class="btn btn-primary btn-sm" 
                  data-toggle="modal" data-target="#newSubscriptionForm" 
                  title="New Subscription">Subscribe Now</button>.
              </small>',

        3 => '<span class="orange text-bold"><i class="fa fa-info-circle"></i>&nbsp; Ongoing Verification</span>
              <hr>
              <small style="font-size:12px;">
                Your application as a <b>&nbsp;<i class="fa fa-user-md"></i>&nbsp; Medical Doctor</b> is being reviewed...
                <br>
                Wait for your documents verification and eventual administrator\'s decision (approval/rejection).
              </small>
                ',

        4 => '<span class="teal text-bold"><i class="fa fa-info-circle"></i>&nbsp; Application Received!</span>
              <hr>
              <small style="font-size:12px;">
                We have received your application as a <b>&nbsp;<i class="fa fa-user-md"></i>&nbsp; Medical Doctor</b> on this platform. Your details will be reviewed within 48hours. 
                <br>
                Keep checking this section for updates on your application status.
              </small>',

        5 => '<span class="red text-bold"><i class="fa fa-info-circle red"></i>&nbsp; Application Rejected!</span>
              <hr>
              <small style="font-size:12px;">
                <b>We cannot accept your application as a medical doctor</b> on our platform at this time. 
                <br>
                Kindly update your documents and reapply later.
              </small>'
    );

    // If the status code is not in the provided list above return the default '0'.
    public function applicationStatus() 
    {
        $status = ($this->application_status > (sizeof(self::$applicationStatus) - 1) || $this->application_status < 0) 
                    ? 0 
                    : intval($this->application_status)
                    ;

        echo self::$applicationStatus[$status];
    }

    // Registration Status
    public static $rStatus = array(
        'user'      => 0,

        'accepted_subscribed' => 1,

        'accepted_not_subscribed' => 2,

        'verifying' => 3,

        'received'  => 4,

        'rejected'  => 5,
    );

    public function updateApplicationStatus($code) 
    {
        $this->application_status = self::$rStatus[$code];

        if ($code == 'rejected') { $this->application_retry_at = Carbon::now()->addDays(7); }

        $this->save();
    }

    public function applicationIsRejected() 
    {
        return $this->application_status == '5';
    }
    /*<!!!-------------- Update Doctor Application Status ---------------->*/



    public function isActive() 
    {
        return !$this->blocked ?: false;
    }

    public function status() 
    {
        return $this->blocked ? 'Blocked':'Active';
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function documents()//uploaded_documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    // public function documents()
    // {
    //     return $this->morphMany(Document::class, 'documentable');
    // }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function application()
    {
        return $this->hasOne(Application::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function prescriptions()
    {
        return $this->hasManyThrough(Prescription::class, Appointment::class, 'user_id', 'appointment_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Appointment Status Related
     */
    public function appointmentsAwaitingConfirmation()
    {
        // 0. New appointment, awaiting doctor's confirmation.
        return $this->appointments()->AwaitingConfirmation();
    }
    public function appointmentsCompleted()
    {
        // 1. Appointment/Consultation completed successfully.
        return $this->appointments()->Completed();
    }
    public function appointmentsConfirmed()
    {
        // 2. Confirmed, awaiting fees payment
        return $this->appointments()->Confirmed();
    }
    public function appointmentsScheduleChangeSuggestion()
    {
        // 3. Schedule change suggestion by doctor
        return $this->appointments()->ScheduleChangeSuggestion();
    }
    public function appointmentsRejected()
    {
        // 4. Rejected by doctor!
        return $this->appointments()->Rejected();
    }
    public function appointmentsOtherDoctorRecommendation()
    {
        // 5. Another doctor recommended.
        return $this->appointments()->OtherDoctorRecommendation();
    }
    public function appointmentsCancelled()
    {
        // 6. Cancelled by patient
        return $this->appointments()->Cancelled();
    }
    public function appointmentsUncompleted()
    {
        // All uncompleted Appointments.
        return $this->appointments()->Uncompleted();
    }
    public function appointmentsAwaitingAppointmentTime()
    {
        // Confirmed, payment made, awaiting appointment time.
        return $this->appointments()->AwaitingAppointmentTime();
    }



    public function doctors()
    {
        $ids = $this->appointments()
                  // \App\Appointment::where('user_id', $this->id)
                  ->completed()
                  ->pluck('doctor_id')
                  ->toArray()
                  ;
        $doctorIds = array_unique($ids);

        return Doctor::whereIn('id', $doctorIds)->get();

        // return $this->hasManyThrough(Doctor::class, Appointment::class, 'user_id', 'user_id')
        //     ->whereHas('appointments', function($query){
        //         $query->where('user_id', $this->id)
        //               // ->completed()
        //         ;
        //     });
    }


    public function getDoctorsAttribute()
    {
        return $this->doctors();
    }

    public function getDoctorsCountAttribute()
    {
        return $this->doctors()->count();
    }


    /**
     * Get all doctors that has attended to this user before.
     * 
     * @return array
     */
    public function inPastAttendingDoctors()
    {
        $ids = $this->doctors()
                    ->pluck('id')->toArray();

        $doctorIds = array_unique($ids);

        return in_array(request()->user->id, $doctorIds);
    }

    public function inAllAttendingDoctors()
    {
        $ids = $this->appointments()
                  ->pluck('doctor_id')
                  ->toArray()
                  ;

        $doctorIds = array_unique($ids);

        return in_array(request()->user->id, $doctorIds);
    }


    /**
     * These getAttributes are API endpoint candidates.
     * Gets better use with js frameworks.
     * Called directly from the model to prevent unnecessary call to api.
     */
    public function getLinkAttribute()
    {
      return route('users.show', $this);
    }

    public function getIsVerifiedAttribute()
    {
        return $this->isVerified();
    }


    # Admin Auth Related
    public function getIsAuthenticatedSuperAdminAttribute() 
    {
        return $this->isAuthenticatedSuperAdmin();
    }

    public function getIsAuthenticatedAdminAttribute() 
    {
        return $this->isAuthenticatedAdmin();
    }

    public function getIsAuthenticatedStaffAttribute() 
    {
        return $this->isAuthenticatedStaff(); 
    }

    public function getIsSuperAdminAttribute() 
    {
        return $this->isSuperAdmin();
    }

    public function getIsAdminAttribute() 
    {
        return $this->isAdmin();
    }

    public function getIsAdministratorAttribute() 
    {
        return $this->isAdministrator();
    }

    public function getIsStaffAttribute() 
    {
        return $this->isStaff();
    }



    # Doctor Related
    public function getIsAuthenticatedDoctorAttribute() 
    {
        return $this->isAuthenticatedDoctor();
    }

    public function getIsDoctorAttribute() 
    {
        return $this->isDoctor(); 
    }
 
    public function getIsDoctorUserAttribute() 
    {
        return $this->isDoctorUser(); 
    }

    public function getIsPotentialDoctorAttribute() 
    {
        return $this->as_doctor == '1' && $this->application_status != '1';
    }



    public function getTypeAttribute() 
    {
        return $this->type();
    }

    public function getStatusAttribute() 
    {
        return $this->status();
    }


    # Appiontments Related
    public function getAppointmentsListAttribute() 
    {
        return route('appointments.index', $this);
    }

    public function getCompletedAppointmentsListAttribute() 
    {
        return route('appointments.index', ['user'=> $this, 'status' => 'success']);
    }

    public function getUpcomingAppointmentsListAttribute() 
    {
        return route('appointments.index', ['user'=> $this, 'status' => 'awaiting-appointment-time']);
    }    

    public function getPendingAppointmentsListAttribute() 
    {
        return route('appointments.index', ['user'=> $this, 'status' => 'awaiting-confirmation']);
    }


    public function getPrescriptionsListAttribute() 
    {
        return route('prescriptions.index', $this);
    }

    public function getTransactionsListAttribute() 
    {
        return route('transactions.index', $this);
    }

    public function getSubscriptionsListAttribute() 
    {
        return route('subscriptions.index', $this);
    }

    public function getTransactionsCountAttribute() 
    {
        return $this->transactions()->where('status', '1')->count();
    }

    public function getAppointmentsCountAttribute() 
    {
        return $this->appointments()->where('status', '1')->count();
    }

    public function getSubscriptionsCountAttribute() 
    {
        return $this->subscriptions()->where('status', '1')->count();
    }
}
