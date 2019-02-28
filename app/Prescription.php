<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
      'appointment_id','message_id','usage','comment', // 'status'
    ];

    protected $appends = ['user','doctor'];

    protected $with = ['drugs'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /* Opposite of User@prescriptions::hasManyThrough
     *
     * Using attribute helps prevent error thrown by belongsTo() clashes.
     */
    public function getUserAttribute()
    {
        return $this->appointment->user;
    }

    /* Opposite of Doctor@prescriptions::hasManyThrough
     *
     * Using attribute helps prevent error thrown by belongsTo() clashes.
     */
    public function getDoctorAttribute()
    {
        return $this->appointment->doctor;
    }

    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }
}
