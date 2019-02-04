<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [        
        'id','user_id','email','phone','slug','about',                          // Profile      
        'main_language','second_language','other_languages',                    // Language        
        'country_id','state_id','home_address','work_address','location',       // Location        
        'rate','session','first_appointment','available','subscription_ends_at',// Work        
        'graduate_school','degree','residency','specialty_id',                  // Education        
        'verified_at','verified_by','revoked' // Others
    ];

    protected $dates = ['verified_at','subscription_ends_at','first_appointment'];

    protected $with = ['specialty','user'];

    protected $appends = [
      'name','link','avatar','practice_years','is_active','availability_text',
      'license_status',
      'rating','rating_digit',
      'adjusted_subscription_end','is_subscribed','patients_count',
      'pending_appointments_count','appointments_count','transactions_count','subscriptions_count',
      'appointments_list','transactions_list','subscriptions_list','prescriptions_list',
      'completed_appointments_list','upcoming_appointments_list','pending_appointments_list',
    ];

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
        $current_workplace = $this->workplaces()->where('current', 1)->first();

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

    public function patients()
    {
        $ids = $this->appointments()
                ->completed()
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
    public function inPastPatients()
    {
        $ids = $this->patients()
                    ->pluck('id')->toArray();

        $patientIds = array_unique($ids);

        return in_array(request()->user()->id, $patientIds);
    }

    public function inAllPatients()
    {
        $ids = $this->appointments()
                  ->pluck('user_id')
                  ->toArray()
                  ;

        $patientIds = array_unique($ids);

        return in_array(request()->user()->id, $patientIds);
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
        return $this->subscription_ends_at > Carbon::now();
    }

    /**
     * License withdrawn.
     */
    public function isSuspended()
    {
        return $this->revoked == '1';
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
        return $this->isSubscribed() && $this->isAvailable();
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

    public function getRatingAttribute()
    {
        $total_reviews = $this->appointments()->reviewed()->get()->count();

        $average_rating = $this->appointments()->reviewed()->avg('rating');

        $rated = $average_rating ? round($average_rating, 2) . '/5': 'no rating';

        $rating = $rated . ' ('. $total_reviews .')';
        
        return $rating;
    }

    public function getRatingDigitAttribute()
    {
        $average_rating = intval($this->appointments()->reviewed()->avg('rating'));

        return $average_rating;
    }

    public function getNameAttribute()
    {
        return $this->user->name;
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
      return is_null($this->subscription_ends_at) ? Carbon::parse(Carbon::now())->subSeconds(1) : $this->subscription_ends_at;
    }





    # Appiontments Related
    public function getAppointmentsListAttribute() 
    {
        return route('dr_appointments', $this);
    }

    public function getCompletedAppointmentsListAttribute() 
    {
        return route('dr_appointments', ['doctor'=> $this, 'status' => 'success']);
    }

    public function getUpcomingAppointmentsListAttribute() 
    {
        return route('dr_appointments', ['doctor'=> $this, 'status' => 'awaiting-appointment-time']);
    }    

    public function getPendingAppointmentsListAttribute() 
    {
        return route('dr_appointments', ['doctor'=> $this, 'status' => 'awaiting-confirmation']);
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

    public function getAvailabilityTextAttribute() 
    {
        return $this->availabilityText();
    }

    public function getLicenseStatusAttribute()
    {
        return $this->revoked ? 'Revoked':'Active';
    }
}
