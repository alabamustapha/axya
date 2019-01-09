<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        // Profile
        'id','user_id','email','phone','slug','about',
        // Language
        'main_language','second_language','other_languages',
        // Location
        'country_id','state_id','home_address','work_address','location',
        // Work
        'rate','session','first_appointment','available','subscription_ends_at',
        // Education
        'graduate_school','degree','residency','specialty_id',
        // Others
        'verified_at','verified_by'
    ];

    protected $dates = ['verified_at','subscription_ends_at','first_appointment'];

    protected $with = ['specialty','user'];

    protected $appends = ['name','link','avatar','practice_years','rating','rating_digit'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
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
        return $this->hasMany(Workplace::class)->where('current', 1)->first();
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

        return in_array(request()->user->id, $patientIds);
    }

    public function inAllPatients()
    {
        $ids = $this->appointments()
                  ->pluck('user_id')
                  ->toArray()
                  ;

        $patientIds = array_unique($ids);

        return in_array(request()->user->id, $patientIds);
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
        return $this->id == auth()->id();
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
    public function is_subscribed()
    {
        return (bool) $this->subscription_ends_at > Carbon::now();
    }
    public function subscriptionStatus()
    {
        echo $this->is_subscribed() 
                  ? '<span class="green"title="You may accept appointments.">subscribed</span>'
                  : '<span class="red" title="You cannot accept appointments at this time.">not subscribed</span>'
                  ;
    }
    public function scopeIsSubscribed($query)
    {
        return $query->where('subscription_ends_at', '>', Carbon::now());
    }

    /**
     * Is Available for Appointments.
     */
    public function scopeIsAvailable($query)
    {
        return $query->where('available', '1');
    }

    public function availabilityText()
    {
      echo $this->is_active()
              ? 'available'
              : 'unavailable'
              ;
    }

    public function subsrciptionStatusText()
    {
      return $this->is_subscribed()
              ? 'available'
              : 'unavailable'
              ;
    }

    // /**
    //  * Subscribed and Available for Appointments.
    //  */
    public function is_active()
    {
        return (bool) ($this->is_subscribed() && $this->available);
    }
    public function scopeIsActive($query)
    {
        return $query->isSubscribed()->isAvailable();
    }

    public function scopeIsSubscribedAndUnAvailable($query)
    {
        return $query->isSubscribed()
                     ->where('available', '0')
                     ;
    }

    /**** ~API Candidates~****/

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
}
