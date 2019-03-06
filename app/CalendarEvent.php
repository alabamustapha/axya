<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable =[
      'user_id', 'start', 'end', 'title', 'content', 'contentFull', 'class', 'icon', 'background', 'eventable_id', 'eventable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning messageable models.
     */
    public function eventable()
    {
        return $this->morphTo(); /* Appointment::class, Medication::class, Transaction::class */
    }

    public function type()
    {
        return (new \ReflectionClass($this->eventable_type))->getShortName();
    }
}
