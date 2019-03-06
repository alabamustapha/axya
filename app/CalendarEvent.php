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
        // 1.
        return (new \ReflectionClass($this->eventable_type))->getShortName();

        /* 2.
            $type_frags = explode('\\', $this->messageable_type);
            $end = end($type_frags);

            return $end;
        */
    }
}
