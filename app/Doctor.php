<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
      'id','user_id','slug','specialty_id','first_appointment','graduate_school','available','subscription_ends_at','verified_at','verified_by',
    ];

    protected $dates = ['verified_at','subscription_ends_at','first_appointment'];

    protected $appends = ['practice_years'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function specialties()
    // {
    //     return $this->belongsToMany(Specialty::class, 'doctor_specialty', 'id', 'id');
    // }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function workplaces()
    {
        return $this->hasMany(Workplace::class);
    }

    public function patients()
    {
        // $patientIds = $this->appointments()
        //                   ->successful() // Scope on Appointment Class
        //                   ->pluck('user_id')
        //                   ->toArray();

        // return App\User::whereIn('id', $patientIds)->get();
        // // return $this->hasMany(Doctor::class);
        return $this->hasMany(User::class, 'id');
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
        return $this->id === auth()->id();
    }

    public function dummyAvatar()
    {
      $img = 'dummy_avatar'. random_int(1, 9) .'.jpg';
      return config('app.url').'/images/doctor_images/' . $img;
    }

    public function getPracticeYearsAttribute()
    {
      return Carbon::now()->diffInYears($this->first_appointment);
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
              ? 'class="available" title="Avaialble for appointments"'
              : 'class="unavailable" title="Unavaialble for appointments"'
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
}
