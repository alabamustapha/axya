<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $dates = ['start_date', 'end_date'];

    protected $fillable = [
        'user_id', 'title', 'prescription_id', 'appointment_id', 'description', 'start_date', 'start_time', 'end_date', 'notify_by', 'recurrence', 'recurrence_type',
    ];

    public function calendar_events()
    {
        return $this->morphMany(CalendarEvent::class, 'eventable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function getStartAttribute()
    {
        return $this->start_date->format('d/M/y');
    }

    public function getStartTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('h:ia');
    }

    public function getEndAttribute()
    {
        return $this->end_date->format('d/M/y');
    }

    public $reccurrenceInMinutes = array(
        'minutes' => 1,
        'hours'   => 60,
        'days'    => 60 * 24,
        'weeks'   => 60 * 24 * 7,
        'months'  => 60 * 24 * 7 * 4,
        'years'   => 60 * 24 * 7 * 4 * 52,
    );
}
