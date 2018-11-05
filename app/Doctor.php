<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
      'id','user_id','speciality','status','available','subscription_ends_at','verified_at','verified_by',
    ];

    protected $dates = ['verified_at', 'subscription_ends_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patients()
    {
        return $this->hasMany(User::class, 'id');
    }

    public function dummyAvatar()
    {
      $img = 'dummy_avatar'. random_int(1, 4) .'.jpg';
      return config('app.url').'/images/doctor_images/' . $img;
    }


    /**
     * Has ongoing subscription.
     */
    public function is_subscribed()
    {
        return (bool) $this->subscription_ends_at > Carbon::now();
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
