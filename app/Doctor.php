<?php

namespace App;

use Cache;
use App\User;
use Carbon\Carbon;
use App\Traits\DoctorViewsTrait;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use DoctorViewsTrait;

    protected $fillable = [        
        'id','user_id','email','phone','slug','about',                          // Profile      
        'main_language','second_language','other_languages',                    // Language        
        'country_id','state_id','home_address','work_address','location',       // Location
        'region_id','city_id',        
        'rate','session','first_appointment','available','subscription_ends_at',// Work        
        'graduate_school','degree','residency','specialty_id',                  // Education        
        'verified_at','verified_by','revoked', 'serialized_schedules' // Others
    ];

    protected $dates = ['verified_at','subscription_ends_at','first_appointment'];

    protected $with = ['specialty','user'];

    protected $appends = [
      'name','link','avatar','practice_years','is_active','availability_text',
      'license_status','is_suspended','availability_status','subscription_end_formatted','is_online',
      'rating','rating_digit',
      'adjusted_subscription_end','is_subscribed','patients_count',
      'pending_appointments_count','appointments_count','transactions_count','subscriptions_count',
      'appointments_list','transactions_list','subscriptions_list','prescriptions_list',
      // From serialized schedules
      'sunday_schedules', 'monday_schedules', 'tuesday_schedules', 'wednesday_schedules', 'thursday_schedules', 'friday_schedules', 'saturday_schedules',
    ];


    /**
     * All earnings summed from accross all successfyul appointment fees.
     */
    public function totalEarning()
    {
        return $this->transactions
                    ->where('status', '1')
                    ->sum('doctor_earning')
                    ;
    }

    /**
     * Sum of all successful payouts.
     */
    public function totalPayout()
    {
        return $this->user->payouts
                    ->where('status', '1')
                    ->sum('amount')
                    ;
    }

    public function currentBalance()
    {
        return $this->totalEarning() - $this->totalPayout();
    }

    public function hasCashableBalance()
    {
        return (bool) ($this->currentBalance() > setting('minimum_payout'));
    }

    public function canMakePayout()
    {
        return (bool) $this->hasCashableBalance() && setting('payout_on');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function revokeLicense() 
    {
        $this->revoked = '1';
        $this->update();
    }

    public function restoreLicense()
    {
        $this->revoked = '0';
        $this->update();
    }

    // public function specialties()
    // {
    //     return $this->belongsToMany(Specialty::class, 'doctor_specialty', 'id', 'id');
    // }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function prescriptions()
    {
        return $this->hasManyThrough(Prescription::class, Appointment::class, 'doctor_id', 'appointment_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);//, 'doctor_id'
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

    public function workplaces()
    {
        return $this->hasMany(Workplace::class);
    }

    public function currentWorkplace()
    {
        return $this->workplaces()->where('current', 1)->first();
    }

    public function updateCurrentWorkplace($rq)
    {
        $current_workplace = $this->currentWorkplace();

        if (!is_null($current_workplace) && $rq->workplace_id != $current_workplace->id){
            $current_workplace->update(['current'=> 0]);

            $this->workplaces()
              ->find($rq->workplace_id)
              ->update(['current'=> 1])
              ;
        }
        else {
            $this->workplaces()
              ->find($rq->workplace_id)
              ->update(['current'=> 1])
              ;
        }

        return;
    }
    

    /**
     * Schedules Related Methods
     *
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }


    public function hasSundaySchedule()   { return $this->schedules()->where('day_id', '1')->count(); }
    public function hasMondaySchedule()   { return $this->schedules()->where('day_id', '2')->count(); }
    public function hasTuesdaySchedule()  { return $this->schedules()->where('day_id', '3')->count(); }
    public function hasWednesdaySchedule(){ return $this->schedules()->where('day_id', '4')->count(); }
    public function hasThursdaySchedule() { return $this->schedules()->where('day_id', '5')->count(); }
    public function hasFridaySchedule()   { return $this->schedules()->where('day_id', '6')->count(); }
    public function hasSaturdaySchedule() { return $this->schedules()->where('day_id', '7')->count(); }

    public function serializedSchedules()
    {
        $default_schedules = [
            '1'=>[],
            '2'=>[],
            '3'=>[],
            '4'=>[],
            '5'=>[],
            '6'=>[],
            '7'=>[],
        ];

        return $this->serialized_schedules ? unserialize($this->serialized_schedules) : $default_schedules;
    }

    /**
     * Each save is for a single day only. eg Mon, Sat.
     * 
     * Normal schedule table save.
     */
    public function saveSchedules($request)
    {
        $dayId = $request->day_id;
        $this->schedules()
               ->where('day_id', $dayId)
               ->delete()
               ;

        foreach ($request->schedules as $schedule) {
            $schedule = array_merge($schedule, [
                'day_id'    => $dayId,
            ]);

            $this->schedules()->create($schedule);
        }
    }

    /**
     * Serialized schedule doctor's table field save.
     * 
     */
    public function saveSerializedSchedules($request)
    {
        $schedules = $this->serializedSchedules();
        $dayId     = $request->day_id;

        # 1. Extract out the sent start_at/end_at times from Request payload.
        $rqSchedules = [];
        foreach ($request->schedules as $schedule) {
            (count($schedule) > 2) 
            ? array_push($rqSchedules, array_slice($schedule, 3,2))
            : array_push($rqSchedules, $schedule)
            ;
        }

        # 2. Empty the day's entire array and merge in the incoming start/end time.
        $daySchedules = $schedules[$dayId];
        $daySchedules = [];
        foreach ($rqSchedules as $schedule) {
            array_push($daySchedules, $schedule);
        }

        # 3. Push day's schedules into the unserialized schedules array, 
        #    Serialize and Save to DB.
            array_push($schedules[$dayId], $daySchedules);
        $this->serialized_schedules = serialize($schedules);
        $this->save();
    }
    
    // Normal Db Schedules...
    public function getDbSundaySchedulesAttribute()   { return $this->schedules()->where('day_id', '1')->get(); }
    public function getDbMondaySchedulesAttribute()   { return $this->schedules()->where('day_id', '2')->get(); }
    public function getDbTuesdaySchedulesAttribute()  { return $this->schedules()->where('day_id', '3')->get(); }
    public function getDbWednesdaySchedulesAttribute(){ return $this->schedules()->where('day_id', '4')->get(); }
    public function getDbThursdaySchedulesAttribute() { return $this->schedules()->where('day_id', '5')->get(); }
    public function getDbFridaySchedulesAttribute()   { return $this->schedules()->where('day_id', '6')->get(); }
    public function getDbSaturdaySchedulesAttribute() { return $this->schedules()->where('day_id', '7')->get(); }

    // Serialized Doctor Field Schedules...
    public function getSundaySchedulesAttribute()   { return $this->serializedSchedules()['1']; }
    public function getMondaySchedulesAttribute()   { return $this->serializedSchedules()['2']; }
    public function getTuesdaySchedulesAttribute()  { return $this->serializedSchedules()['3']; }
    public function getWednesdaySchedulesAttribute(){ return $this->serializedSchedules()['4']; }
    public function getThursdaySchedulesAttribute() { return $this->serializedSchedules()['5']; }
    public function getFridaySchedulesAttribute()   { return $this->serializedSchedules()['6']; }
    public function getSaturdaySchedulesAttribute() { return $this->serializedSchedules()['7']; }    

    // Checking for a day's schedules... From serialized data array. better than DB queries.
    public function getHasSundaySchedulesAttribute()   { return (bool) count($this->serializedSchedules()['1']); }
    public function getHasMondaySchedulesAttribute()   { return (bool) count($this->serializedSchedules()['2']); }
    public function getHasTuesdaySchedulesAttribute()  { return (bool) count($this->serializedSchedules()['3']); }
    public function getHasWednesdaySchedulesAttribute(){ return (bool) count($this->serializedSchedules()['4']); }
    public function getHasThursdaySchedulesAttribute() { return (bool) count($this->serializedSchedules()['5']); }
    public function getHasFridaySchedulesAttribute()   { return (bool) count($this->serializedSchedules()['6']); }
    public function getHasSaturdaySchedulesAttribute() { return (bool) count($this->serializedSchedules()['7']); }

    /** ! Schedules Related Methods **/



    public function patients()
    {
        $ids = $this->appointments()
                ->activateMessaging()
                ->pluck('user_id')
                ->toArray()
                ;
        $patientIds = array_unique($ids);

        return User::whereIn('id', $patientIds)->get();
    }

    public function getPatientsAttribute()
    {
        return $this->patients();
    }

    public function getPatientsCountAttribute()
    {
        return $this->patients()->count();
    }


    /**
     * Get all doctors that has attended to this user before.
     * 
     * @return array
     */
    public function hasWaitedPatientBefore($userId)
    {
        $ids = $this->patients()
                    ->pluck('id')->toArray();

        $patientIds = array_unique($ids);

        return in_array($userId, $patientIds);
    }

    public function hasActivityWithPatient($userId)
    {
        $ids = $this->appointments()
                  ->pluck('user_id')
                  ->toArray()
                  ;

        $patientIds = array_unique($ids);

        return in_array($userId, $patientIds);
    }



    /**
     * Route key
     * 
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }

    /**
     * Check if logged in user is the present resource owner.
     * 
     * @return boolean
     */
    public function isAccountOwner()
    {
        return $this->id == request()->user()->id; // auth()->id();
    }

    public function dummyAvatar()
    {
      $img = 'a'. random_int(1, 8) .'.jpg';
      return config('app.url').'/images/' . $img;
    }

    /**
     * Get male doctors from users model.
     */
    public static function maleMembers()
    {
        return \App\User::whereHas('doctor')->where('gender', 'Male')->get();
    }

    /**
     * Get female doctors from users model.
     */
    public static function femaleMembers()
    {
        return \App\User::whereHas('doctor')->where('gender', 'Female')->get();
    }

    /**
     * Get doctors with other sexuality from users model
     */
    public static function otherGenders()
    {
        return \App\User::whereHas('doctor')->where('gender', 'Other')->get();
    }


    /**
     * Has ongoing subscription.
     */
    public function isSubscribed()
    {
        return !! (!is_null($this->subscription_ends_at) && $this->subscription_ends_at > Carbon::now());
    }

    /**
     * License withdrawn.
     */
    public function isSuspended()
    {
        return $this->revoked == '1';
    }

    public function hasSchedules()
    {
        // return $this->schedules->count();
        return ((bool) 
               count($this->serializedSchedules()['1'])
            || count($this->serializedSchedules()['2'])
            || count($this->serializedSchedules()['3'])
            || count($this->serializedSchedules()['4'])
            || count($this->serializedSchedules()['5'])
            || count($this->serializedSchedules()['6'])
            || count($this->serializedSchedules()['7'])
        );
    }

    /**
     * Check the ONLINE STATUS of this DOCTOR.
     * 
     * @return  boolean
     */
    public function isOnline() 
    {
        return $this->user->isOnline() && $this->user->isAuthenticatedDoctor();
    }

    public function isAvailable()
    {
        return $this->available == '1' && $this->revoked == '0';
    }

    /**
     * Subscribed and Available for Appointments.
     */
    public function isActive()
    {
        return $this->isSubscribed() && $this->isAvailable() && $this->hasSchedules();
    }

    public function subscriptionStatus()
    {
        return $this->isSubscribed() 
                  ? 'subscribed'
                  : 'not subscribed'
                  ;
    }
    public function scopeSubscribed($query)
    {
        return $query->where('subscription_ends_at', '>', Carbon::now());
    }

    public function scopeSuspended($query)
    {
        return $query->where('revoked', '1');
    }

    /**
     * Is Available for Appointments.
     */
    public function scopeAvailable($query)
    {
        return $query->where('available', '1')
                     ->where('revoked', '0')
                     ;
    }

    public function scopeActive($query)
    {
        return $query->subscribed()
                     ->available()
                     ;
    }

    public function availabilityText()
    {
      return $this->isActive()
              ? 'available'
              : 'unavailable'
              ;
    }

    public function scopeSubscribedAndUnAvailable($query)
    {
        return $query->subscribed()
                     ->where('available', '0')
                     ;
    }

    /**** ~API Candidates~****/

    public function getIsSubscribedAttribute()
    {
        return $this->isSubscribed();
    }

    public function getSubscriptionEndFormattedAttribute()
    {
        return !is_null($this->subscription_ends_at )
             ? $this->subscription_ends_at->format('D M d, Y')
             : null
             ;
    }

    public function appointmentsReviewed()
    {
        return $this->appointments()->reviewed();
    }

    public function getRatingAttribute()
    {
        $total_reviews = $this->appointmentsReviewed()->count();

        $average_rating = $this->appointmentsReviewed()->avg('rating');

        $rated = $average_rating ? round($average_rating, 2) . '/5': 'no rating';

        $rating = $rated . ' ('. $total_reviews .')';
        
        return $rating;
    }

    public function getRatingDigitAttribute()
    {
        $average_rating = intval($this->appointmentsReviewed()->avg('rating'));

        return $average_rating;
    }

    public function getNameAttribute()
    {
        return 'Dr. '. $this->user->name;
    }

    public function getLinkAttribute()
    {
      return route('doctors.show', $this);
    }

    public function getAvatarAttribute()
    {
        return $this->dummyAvatar();//$this->user->avatar;
    }

    public function getPracticeYearsAttribute()
    {
      return Carbon::now()->diffInYears($this->first_appointment);
    }

    public function getEmailAttribute($value)
    {
      return (! is_null($value)) ? $value: $this->user->email;
    }

    public function getPhoneAttribute($value)
    {
      return (! is_null($value)) ? $value: $this->user->phone;
    }

    public function getAdjustedSubscriptionEndAttribute()
    {
      return is_null($this->subscription_ends_at) 
                ? Carbon::parse(Carbon::now())->subSeconds(1) 
                : $this->subscription_ends_at
                ;
    }





    # Appiontments Related
    public function getAppointmentsListAttribute() 
    {
        return route('dr_appointments', $this);
    }


    public function getPrescriptionsListAttribute() 
    {
        return route('dr_prescriptions', $this);
    }

    public function getTransactionsListAttribute() 
    {
        return route('dr_transactions', $this);
    }

    public function getSubscriptionsListAttribute() 
    {
        return route('subscriptions.index', $this);
    }


    /** N + 1 candidates  */
    public function getTransactionsCountAttribute() 
    {
        return $this->transactions()->whereStatus(1)->count();
    }

    public function getAppointmentsCountAttribute() 
    {
        return $this->appointments()->whereStatus(1)->count();
    }

    public function getPendingAppointmentsCountAttribute() 
    {
        return $this->appointments()->whereStatus(0)->count();
    }

    public function getSubscriptionsCountAttribute() 
    {
        return $this->subscriptions()->whereStatus(1)->count();
    }



    public function getIsActiveAttribute() 
    {
        return $this->isActive();
    }

    public function getIsSuspendedAttribute() 
    {
        return $this->isSuspended();
    }

    public function getAvailabilityTextAttribute() 
    {
        return $this->availabilityText();
    }

    public function getLicenseStatusAttribute()
    {
        return $this->revoked ? 'Revoked':'Active';
    }

    public function availabilityStatus()
    {
        // if ($this->is_active) {
        //     echo '<span class="bg-success doc-avail-indicator" title="Available"></span>';
        // }
        // elseif ($this->is_suspended) {
        //     echo '<span class="bg-danger doc-avail-indicator" title="***"></span>';
        // }
        // else {
        //     echo '<span class="bg-warning doc-avail-indicator" title="Unavailable"></span>';
        // }
    }

    public function getAvailabilityStatusAttribute()
    {
        return $this->availabilityStatus($this);
    }


    public function getTotalEarningAttribute()
    {
        return $this->totalEarning();
    }

    public function getTotalPayoutAttribute()
    {
        return $this->totalPayout();
    }

    public function getCurrentBalanceAttribute()
    {
        return $this->currentBalance();
    }

    public function getIsOnlineAttribute() 
    {
        return $this->isOnline();
    }
}
