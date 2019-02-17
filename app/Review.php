<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id','doctor_id','appointment_id','comment','rating',
    ];

    protected $with = [
        'user', 'doctor'
    ];

    protected $appends = [
        'author'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('M d, Y');//format('h:ma M-d, Y');
    }

    public function getAuthorAttribute()
    {
        return $this->user->name;
    }
}
